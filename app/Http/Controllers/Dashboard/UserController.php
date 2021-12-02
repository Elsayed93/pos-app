<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (auth()->user()->isAbleTo('users-read')) {
        //     if ($request->search) {

        //         $users = User::where('first_name', 'like', '%' . $request->search . '%')
        //             ->orWhere('last_name', 'like', '%' . $request->search . '%')
        //             ->whereRoleIs('admin')
        //             ->get();
        //     } else {
        //         $users = User::whereRoleIs('admin')->get();
        //     }
        //     //
        //     return view('dashboard.users.index', compact('users'));
        // } else {
        //     return redirect()->back()->with('error', __('site.Permission Denied'));
        // }


        if (auth()->user()->isAbleTo('users-read')) {

            $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
                return $q->When($request->search, function ($query)  use ($request) {
                    return $query->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                });
            })->latest()->paginate(10);

            //
            return view('dashboard.users.index', compact('users'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->isAbleTo('users-create')) {
            return view('dashboard.users.create');
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->isAbleTo('users-create')) {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'password' => 'required|confirmed',
                'permissions' => 'required',

            ]);

            $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);

            $request_data['password'] = Hash::make($request->password);

            if ($request->has('image')) {
                $img = Image::make($request->image)->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/users_images/') . $request->image->hashName());
            }

            if ($request->image != null) {
                $request_data['image'] = $request->image->hashName();
            } else {

                $request_data['image'] = 'default.jpg';
            }

            // create a new user
            $user =  User::create($request_data);

            // attach super_admin role to user
            $user->attachRole('admin');

            // attach permissions to user
            $user->syncPermissions($request->permissions); // or $user->attachPermissions($request->permissions);

            if ($user) {
                return redirect()->route('dashboard.users.index')->with('success', __('site.added_successfully'));
            } else {
                return redirect()->back()->with('error', __('site.added_failed'));
            }
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
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

        if (auth()->user()->isAbleTo('users-update')) {
            return view('dashboard.users.edit', compact('user'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
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
        if (auth()->user()->isAbleTo('users-update')) {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email,' . $user->id,
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'permissions' => 'required',
            ]);

            $request_data = $request->except(['permissions', 'image']);

            if ($request->has('image')) {
                if ($user->image != 'default.jpg') {
                    Storage::disk('public_uploads')->delete('users_images/' . $user->image);
                }


                $img = Image::make($request->image)->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/users_images/') . $request->image->hashName());

                $request_data['image'] = $request->image->hashName();
            }



            // update user
            $user->update($request_data);

            // attach permissions to user
            $user->syncPermissions($request->permissions); // or $user->attachPermissions($request->permissions);

            if ($user) {
                return redirect()->route('dashboard.users.index')->with('success', __('site.updated_successfully'));
            } else {
                return redirect()->back()->with('error', __('site.updated_failed'));
            }
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->isAbleTo('users-delete')) {
            if ($user->image != 'default.jpg') {
                Storage::disk('public_uploads')->delete('users_images/' . $user->image);
            }
            $user->delete();
            return redirect()->route('dashboard.users.index')->with('success', __('site.deleted_successfully'));
        } else {
            return redirect()->back()->with('error', __('site.Permission Denied'));
        }
    }
}
