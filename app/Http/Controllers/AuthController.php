<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Midtrans\Snap;
use App\Services\Midtrans\CreateSnapTokenService;
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

            session()->flash('success','You Have Been Registerd Successfuly.');

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
                    ->with('error', 'Either Email/Password is Incorrect.');
            }

        } else {
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

    public function profile() {

        $userId = Auth::user()->id;

        $countries = Country::orderBy('name','ASC')->get();

        $user = User::where('id', $userId)->first();

        $address = CustomerAddress::where('user_id', $userId)->first();

        return view('front.account.profile',[
            'user' => $user,
            'countries' => $countries,
            'address' => $address
        ]);
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,except,id',
            'phone' => 'required'
        ]);

        if ($validator->passes()) {
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            session()->flash('success', 'Profile Updated Successfully');

            return response()->json([
                'status' => true,
                'errors' => 'Profile Updated Successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function updateAddress(Request $request)
    {
        $userId = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'country_id' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->passes()) {

            CustomerAddress::updateOrCreate (
                ['user_id' => $userId],
                [
                    'user_id' => $userId,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'country_id' => $request->country_id,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,
    
                ]
            );

            session()->flash('success', 'Address Updated Successfully');

            return response()->json([
                'status' => true,
                'errors' => 'Profile Updated Successfully'
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
        ->with('success', 'You Successfully Logged Out!');
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
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        $data['order'] = $order;

        $orderItems = OrderItem::where('order_id', $id)->get();
        $data['orderItems'] = $orderItems;

        $orderItemsCount = OrderItem::where('order_id', $id)->count();
        $data['orderItemsCount'] = $orderItemsCount;

        $snapToken = $order->snap_token;
         if (is_null($snapToken)) {
             // If snap token is still NULL, generate snap token and save it to database

             $midtrans = new CreateSnapTokenService($order);
             $snapToken = $midtrans->getSnapToken();

             $order->snap_token = $snapToken;
             $order->save();
         }

        //dd($order, $snapToken);

        return view('front.account.order-detail', compact('data', 'snapToken'));
         
        // // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = true;

        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => $order->id,
        //         'gross_amount' => $order->grand_total,
        //     ),
        //     'customer_details' => array(
        //         'first_name' => $order->first_name,
        //         'last_name' => $order->last_name,
        //         'email' => $order->email,
        //         'phone' => $order->mobile,
        //     ),
        // );

        // $snapToken = \Midtrans\Snap::getSnapToken($params);
        // //dd($params, $snapToken);
        // return view('front.account.order-detail', compact('data', 'snapToken'));
    }
    
    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            $order = Order::find($request->order_id);
            $order->update(['payment_status' => '2']);
        }
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
            session()->flash('error','Product Alredy Removed.');
            return response()->json([
                'status' => true,
            ]);
        } else {
            Wishlist::where('user_id',Auth::user()-> id)->where('product_id',$request->id)->delete();
            session()->flash('success','Product Removed Successfully.');
            return response()->json([
                'status' => true,
            ]);
            
        }


    }
}