<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {
        return view('front.account.login');

    }

    public function register() {
        return view('front.account.register');
    }

    public function  processRegister(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email'=> 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        if($validator->passes()) {

            $user = new user;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success','You have been registerd successfuly.');

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

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

                if (!session()->has('url.intended')) {
                    return redirect()->route('account.profile');
                }
                
                return redirect(session()->get('url.intended'));

            } else {
                //session()->flash('error', 'Either email/password is incorrect.');
                return redirect()->route('account.login')
                    ->withInput($request->only('email'))
                    ->with('error', 'Either email/password is incorrect.');
            }

        } else {
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

    public function profile() {
        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
        $data = [];
        $data['customerAddress'] = $customerAddress;
        return view('front.account.profile',$data);
    }

    public function edit($id, Request $request){
        
        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
        if (empty($customerAddress)) {
            $request->session()->flash('error','Record Not Found');
            return redirect()->route('account.profile');
        }
        $data = [];
        $data['customerAddress'] = $customerAddress;
        return view('front.account.edit',$data);
    }

    public function update($id, Request $request) {

        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();

        if(empty($customerAddress)) {
            $request->session()->flash('error', 'Record not found,');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->passes()) {
            $customerAddress->first_name = $request->first_name;
            $customerAddress->last_name = $request->last_name;
            $customerAddress->email = $request->email;
            $customerAddress->mobile = $request->mobile;
            $customerAddress->address = $request->address;
            $customerAddress->apartment = $request->apartment;
            $customerAddress->city = $request->city;
            $customerAddress->state = $request->state;
            $customerAddress->zip = $request->zip;
            $customerAddress->save();

            $request->session()->flash('success','Profile updated successfully.');

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully'
            ]);

    } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login')
        ->with('success', 'You successfully logged out!');
    }

    public function orders() {

        $user = Auth::user();

        $orders = Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();


        $data['orders'] = $orders;
        return view('front.account.order',$data);
    }

    public function orderDetail($id) {
        $data = [];
        $user = Auth::user();
        $order = Order::where('user_id',$user->id)->where('id',$id)->first();
        $data['order'] = $order;

        $orderItems = OrderItem::where('order_id',$id)->get();

        $data['orderItems'] = $orderItems;

        $orderItemsCount = OrderItem::where('order_id',$id)->count();

        $data['orderItemsCount'] = $orderItemsCount;

        return view('front.account.order-detail',$data);
    }

    public function wishlist(){
        $wishlists = Wishlist::where('user_id',Auth::user()->id)->get();
        $data = [];
        $data['wishlists'] = $wishlists;
        return view('front.account.wishlist',$data);
    }

    public function removeProductFromWishList(Request $request) {
        $wishlist = Wishlist::where('user_id',Auth::user()-> id)->where('product_id',$request->id)->first();

        if ($wishlist == null) {
            session()->flash('error','Product alredy removed.');
            return response()->json([
                'status' => true,
            ]);
        } else {
            Wishlist::where('user_id',Auth::user()-> id)->where('product_id',$request->id)->delete();
            session()->flash('success','Product removed successfully.');
            return response()->json([
                'status' => true,
            ]);
            
        }


    }
}