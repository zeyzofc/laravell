<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::latest();

        if(!empty($request->get('keyword'))) {
            $users = $users->where('name','like','%'.$request->get('keyword').'%');
            $users = $users->orWhere('email','like','%'.$request->get('keyword').'%');

        }

        $users = $users->paginate(10);

        return view('admin.users.list',[
            'users' => $users
        ]);

    }

    public function create(Request $request) {
        return view('admin.users.create',[
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'password' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
        ]);

        if ($validator->passes()) {

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            $message = 'User added successfully.';

            session()->flash('success', $message);


            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }


    public function edit($id, Request $request) {
        $users = User::find($id);

        if(empty($users)) {
            $request->session()->flash('error', 'Record not found,');
            return redirect()->route('users.index');
        }
        $data['users'] = $users;
        return view('admin.users.edit',$data);
    }

    public function update($id, Request $request) {

        $users = User::find($id);

        if(empty($users)) {
            $request->session()->flash('error', 'Record not found,');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        if ($validator->passes()) {
            $users->name = $request->name;
            $users->email = $request->email;
            $users->phone = $request->phone;
            $users->save();

            $request->session()->flash('success','Users updated successfully.');

            return response()->json([
                'status' => true,
                'message' => 'Users updated successfully'
            ]);

    } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    

    public function destroy($id, Request $request){
        $users = User::find($id);
        
         if (empty($users)) {
                $request->session()->flash('error','Record Not Found');
                return response([
                    'status' => false,
                    'notFound' =>true
                ]);
            }

            $users->delete();

            $request->session()->flash('success','Users Deleted successfully.');

            return response([
                'status' => true,
                'message' => 'Users Deleted successfully.'
            ]);
    }
}