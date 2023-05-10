<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }
    
    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        $user->roles()->sync([$role->id]);

        return redirect()->route('admin.index');
    }
}
