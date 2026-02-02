<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\fault;
use App\Device;
use DB;

class FaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['faults'] = fault::get();
        return view('admin.fault.index',$this->data);
    }

    public function faultDevice()
    {
        $this->data['deviceFaults'] = DB::table('faults')
        ->join('devicelogs', 'devicelogs.code', '=', 'faults.failure_code')
        ->join('devices', 'devices.device_id', '=', 'devicelogs.device_id')
        ->leftJoin('users as installers', 'installers.id', '=', 'devices.installer_id')
        ->leftJoin('users as owners', 'owners.id', '=', 'devices.user_id')
        ->leftJoin('downloads as doc', 'doc.id', '=', 'faults.doc_id')
        ->select(
            'faults.*',
            'doc.*',
            'devicelogs.device_id',
            'installers.full_name as installer_name',
            'owners.full_name as user_name',
            'owners.id as oid',
        )
        ->get();

        //dd($this->data);

        return view('admin.fault.device_fault',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateDoc(Request $request)
    {
        $request->validate([
            'fault_id' => 'required|exists:faults,id',
            'doc_id' => 'nullable|exists:downloads,id'
        ]);

        $fault = fault::findOrFail($request->fault_id);
        $fault->doc_id = $request->doc_id;
        $fault->save();

        return back()->with('success', 'Document updated successfully.');
}

}
