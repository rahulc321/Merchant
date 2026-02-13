<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{SpinReward, MerchantAddress, CatObject,User};

class SpinController extends Controller
{
    public function index()
    {
        
        $merchants = User::with('addresses')->get();
        $rewards = SpinReward::where('tbl_type',$_REQUEST['key'])->latest()->get();
        
        return view('admin.spin.index', compact('rewards','merchants'));
    }


    public function create()
    {
        return view('admin.spin.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
           // 'type'   => 'required',
            // 'value'  => 'nullable|numeric|min:0',
            // 'chance' => 'required|integer|min:1|max:100',
            //'icon'   => 'required|string',
            'status' => 'required|boolean'
        ]);


        // check total probability
        // $totalChance = SpinReward::sum('chance');

        // if (($totalChance + $request->chance) > 100) {

        //     return back()
        //         ->withInput()
        //         ->with('error', 'Total winning probability cannot exceed 100%. Remaining: '.(100 - $totalChance).'%');
        // }


        SpinReward::create([
            'name'   => $request->name,
            'type'   => $request->type,
            // 'value'  => $request->value ?? 0,
            // 'chance' => $request->chance,
            'icon'   => $request->icon,
            'status' => $request->status,
            'tbl_type' => $request->key
        ]);


        return redirect()
                ->route('admin.spin.index', ['key' => $request->key])
                ->with('success', 'Created successfully!');

    }



    public function edit(SpinReward $spin)
    {
        return view('admin.spin.edit', compact('spin'));
    }


    public function update(Request $request, SpinReward $spin)
    {
        $request->validate([
            'title' => 'required',
            'probability' => 'required|integer|min:1|max:100',
            'icon' => 'nullable|image'
        ]);

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('spin_icons', 'public');
            $spin->icon = $path;
        }

        $spin->update([
            'title' => $request->title,
            'probability' => $request->probability,
            'is_active' => $request->is_active ?? 0
        ]);

        return redirect()->route('spin.index')
            ->with('success','Reward Updated');
    }


    public function deleteSpin($id)
    {   
        $spin = SpinReward::find($id);
        $spin->delete();

        return back()->with('success','Deleted Successfully');
    }

    public function addSpinner($id){

        $this->data['address'] = MerchantAddress::findOrFail($id);
       $this->data['spinners'] = SpinReward::where('status',1)
                    
                    ->get();
        return view('admin.merchant.addspinner',$this->data);
    }

    // /////////////////////////////////////////////////////////// CatObject
    public function listObject($id){
        $rewardsName = SpinReward::find($id);
        $rewards = CatObject::with('category','rewardName')->latest()->where('cat_id', $id)->get();
        
        return view('admin.cat_object.index', compact('rewards','rewardsName'));
    }

    public function addObject($id)
    {   
        $allObjetcs = SpinReward::where('status',1)
                    ->where('tbl_type','object')
                    ->get();
        return view('admin.cat_object.create',compact('allObjetcs','id'));
    }

    public function objectStore(Request $request,$id)
    {
        $request->validate([
            'cat_id'   => 'required|string|max:255',
            'type'   => 'required',
            'value'  => 'nullable|numeric|min:0',
            'chance' => 'required|integer|min:1|max:100',
            'icon'   => 'required|string',
            'status' => 'required|boolean'
        ]);


        // check total probability
        $totalChance = CatObject::where('cat_id', $id)->sum('chance');

        if (($totalChance + $request->chance) > 100) {

            return back()
                ->withInput()
                ->with('error', 'Total winning probability cannot exceed 100%. Remaining: '.(100 - $totalChance).'%');
        }


        CatObject::create([
            'cat_id'   =>$id,
            'obj_id' => $request->cat_id,
            'type'   => $request->type,
            'value'  => $request->value ?? 0,
            'chance' => $request->chance,
            'icon'   => $request->icon,
            'status' => $request->status,
            'tbl_type' => 'cat_object'
        ]);


        return back()
                 
                ->with('success', 'Created successfully!');

    }

    public function deleteSpinObject($id)
    {   
        $spin = CatObject::find($id);
        $spin->delete();

        return back()->with('success','Deleted Successfully');
    }

    public function assignAddress(Request $request)
    {
        $request->validate([
            'spin_id' => 'required',
            'address_ids' => 'required|array'
        ]);

        $spinId = $request->spin_id;
        $addressIds = $request->address_ids;

        // ✅ 1. delete old mappings first
        \DB::table('address_spinner')
            ->where('spinner_id', $spinId)
            ->delete();

        // ✅ 2. insert new mappings
        $insertData = [];

        foreach ($addressIds as $addressId) {
            $insertData[] = [
                'address_id' => $addressId,
                'spinner_id'      => $spinId,
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        \DB::table('address_spinner')->insert($insertData);

        return back()->with('success', 'Addresses assigned successfully!');
    }

    public function getSpinAddresses($id)
    {
        $addresses = \DB::table('address_spinner')
            ->where('spinner_id', $id)
            ->pluck('address_id');

        return response()->json($addresses);
    }

    public function viewSpinner($id){
        $spinData = \DB::table('address_spinner')->where('address_id',$id)->first();
        $this->data['spData'] = CatObject::with('category','rewardName')->where('cat_id',$spinData->spinner_id)->get();
        return view('sp',$this->data);
    }

}
