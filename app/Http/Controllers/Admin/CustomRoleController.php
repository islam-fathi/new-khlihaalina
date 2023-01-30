<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AdminRole;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomRoleController extends Controller
{
    public function create()
    {
        $rl=AdminRole::whereNotIn('id',[1])->latest()->get();
        return view('admin-views.custom-role.create',compact('rl'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:admin_roles',
        ],[
            'name.required'=>'Role name is required!'
        ]);

        DB::table('admin_roles')->insert([
            'name'=>$request->name,
            'module_access'=>json_encode($request['modules']),
            'status'=>1,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

        Toastr::success('Role added successfully!');
        return back();
    }

    public function edit($id)
    {
        $role=AdminRole::where(['id'=>$id])->first(['id','name','module_access']);
        return view('admin-views.custom-role.edit',compact('role'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required'=>'Role name is required!'
        ]);

        DB::table('admin_roles')->where(['id'=>$id])->update([
            'name'=>$request->name,
            'module_access'=>json_encode($request['modules']),
            'status'=>1,
            'updated_at'=>now()
        ]);

        Toastr::info('Role updated successfully!');
        return back();
    }
}
