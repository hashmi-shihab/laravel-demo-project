<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function profileEdit()
    {
        try {
            $user = User::where('id',Auth::user()->id)->first();
            return view('admin.profile',compact('user'));
        }catch (\Throwable $th){
            return back()->with('error', /*'Something went wrong!'*/$th->getMessage());
        }
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        try {
            $user = auth()->user();
            $update_data = $request->all();
            if ($request->has('password')) $update_data['password'] = Hash::make($request->password);
            $user->update($update_data);
            return redirect()->back()->with('success', 'Profile updated successfully!');
        }catch (\Throwable $th){
            return back()->with('error', /*'Something went wrong!'*/$th->getMessage());
        }
    }
}
