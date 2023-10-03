<?php

namespace App\Http\Controllers\admin;

use App\Charts\MonthlyUsersChart;
use App\Charts\PendapatanBulanan;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

    class HomeController extends Controller
    {
        public function index(PendapatanBulanan $chart) {
        $paymentStatus = [1, 3, 4];

        // Calculate total earnings for this month
        $currentMonth = Carbon::now()->startOfMonth();
        $currentMonthEarnings = Order::where('payment_status', 2)
            ->where('updated_at', '>=', $currentMonth)
            ->sum('grand_total');
        
        // Calculate total earnings
        $totalEarnings = Order::where('payment_status', 2)->sum('grand_total');

        $categoryCount = Category::count();
        $userCount = User::where('role', 1)->count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $orderUnpaidCount = Order::whereIn('payment_status', $paymentStatus)->count();
        $orderPaidCount = Order::where('payment_status', 2)->count();
        $latestUser = User::orderBy('id', 'DESC')->where('status',1)->where('role',1)->take(8)->get();
        $latestProducts = Product::orderBy('id', 'DESC')->where('status',1)->take(4)->get();
        $orders = Order::latest('orders.created_at')->select('orders.*','users.name','users.email');
        $orders = $orders->leftJoin('users', 'users.id','orders.user_id')->take(6)->get();

        $data = [
            'categoryCount' => $categoryCount,
            'userCount' => $userCount,
            'productCount' => $productCount,
            'orderCount' => $orderCount,
            'orderUnpaidCount' => $orderUnpaidCount,
            'orderPaidCount' => $orderPaidCount,
            'latestUser' => $latestUser,
            'latestProducts' => $latestProducts,
            'orders' => $orders,
            'currentMonthEarnings' => $currentMonthEarnings,
            'totalEarnings' => $totalEarnings,
            'chart' => $chart->build(),
        ];
        
        return view('admin.dashboard', compact('data'));
    }
    
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}