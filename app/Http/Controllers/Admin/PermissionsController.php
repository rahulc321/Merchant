<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert;


class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());
        
        session()->flash('success', 'You have successfully added!');
        return redirect()->route('admin.permissions.index');

    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update($id, Request $request)
    {
        # validate the request
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        # check if the permission title already exists (excluding the current one)
        $existingPermission = Permission::where('title', $request->title)
            ->where('id', '!=', $id)
            ->first();
    
        # if it exists, show an error
        if ($existingPermission) {
            session()->flash('error', 'Permission title already exists!');
             
            return redirect()->back()->withInput();
        }
    
        # find and update the permission
        $permission = Permission::find($id);
        if (!$permission) {
            Alert::error('Error', 'Permission not found!');
            return redirect()->route('admin.permissions.index');
        }
    
        $permission->title = $request->title;
        $permission->save();
    
        session()->flash('success', 'You have successfully updated!');
        return redirect()->route('admin.permissions.index');
    }
    

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();
        session()->flash('warning', 'You have successfully deleted!');
        return back();

    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        Permission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
