<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        $paymentStatus = [1, 3, 4];

        $categoryCount = Category::count();
        $data['categoryCount'] = $categoryCount;

        $userCount = User::where('role', 1)->count(); // Count users with role = 1
        $data['userCount'] = $userCount;

        $productCount = Product::count();
        $data['productCount'] = $productCount;

        $orderCount = Order::count();
        $data['orderCount'] = $orderCount;

        $orderUnpaidCount = Order::whereIn('payment_status', $paymentStatus)->count(); // Count orders with payment_status in [2, 3, 4]
        $data['orderUnpaidCount'] = $orderUnpaidCount;

        $orderPaidCount = Order::where('payment_status', 2)->count(); // Count orders with payment_status in [2, 3, 4]
        $data['orderPaidCount'] = $orderPaidCount;

        return view('admin.dashboard', compact('data'));
        //$admin = Auth::guard('admin')->user();
        //echo 'Welcome'.$admin->name.' <a href="'.route('admin.logout').'">Logout</a>';
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}