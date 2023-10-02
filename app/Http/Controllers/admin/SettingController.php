<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function ShowChangePasswordForm() {
        return view('admin.change-password');
    }

    public function processChangePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        $id = Auth::guard('admin')->user()->id;
        
        $admin = User::where('id',$id)->first(); 

        if($validator->passes()) {

            if(!Hash::check($request->old_password, $admin->password)){
                session()->flash('error','Your old password is incorrect, please try again.');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id',$id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success','You have successfully changed your password');
            return response()->json([
                'status' => true,
            ]);

            
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
