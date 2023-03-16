<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateNameEmailUserRequest;
use App\Http\Requests\UpdatePasswordUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->can('view own profile') && !$user->can('view all profiles')){
            $users = User::find($user->id);
            return response()->json([
                'status' => 'success',
                'users' => $users
            ]);
        }
        $users = User::orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateNameEmail(UpdateNameEmailUserRequest $request, User $user)
    {
        $userauth = Auth::user();
        if($userauth->id != $user->id){
            return response()->json([
                'status' => true,
                'message' => 'You do not have permission to update this user'
            ], 200);
        }

        $user->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => "User Updated successfully!",
            'user' => $user
        ], 200);
    }
    public function updatePassword(UpdatePasswordUserRequest $request, User $user)
    {

        $userauth = Auth::user();

        if($userauth->id != $user->id){
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to update this user'
            ], 200);
        }
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => "User Updated successfully!",
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $userauth = Auth::user();
        if($userauth->id != $user->id){
            return response()->json([
                'status' => true,
                'message' => 'You do not have permission to delete this user'
            ], 200);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ], 200);
    }

}
