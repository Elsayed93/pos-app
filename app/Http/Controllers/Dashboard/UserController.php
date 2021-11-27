<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);

        $request_data['password'] = Hash::make($request->password);

        // create a new user
        $user =  User::create($request_data);

        // attach super_admin role to user
        $user->attachRole('admin');

        // attach permissions to user
        $user->syncPermissions($request->permissions); // or $user->attachPermissions($request->permissions);

        if ($user) {
            return redirect()->route('dashboard.users.index')->with('success', __('site.added_successfully'));
        } else {
            dd('error store');

            return redirect()->back()->with('error', __('site.added_failed'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);

        $request_data = $request->except(['permissions']);

        // update user
        $user->update($request_data);

        // attach permissions to user
        $user->syncPermissions($request->permissions); // or $user->attachPermissions($request->permissions);

        if ($user) {
            return redirect()->route('dashboard.users.index')->with('success', __('site.updated_successfully'));
        } else {
            return redirect()->back()->with('error', __('site.updated_failed'));
        }
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
}
