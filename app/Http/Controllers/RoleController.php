<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    //
    public function index(){
        $roles = Role::all();

        return view('admin.roles.index', ['roles'=>$roles]);
    }

    public function create(){
        $permissions = Permission::all();
        return view('admin.roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        //assigning permission
        $role->permissions()->attach($data['permissions']);

        return redirect()->route('admin.roles.index')->with(['success'=> 'Role created successfully.']);
    }

    public function edit($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('admin.roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    public function update(Request $request, $id){
        $data = $request->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name
        ]);
        $role->permissions()->sync($data['permissions']);
        return redirect()->route('admin.roles.index')->with(['success'=> 'Role updated successfully.']);
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
