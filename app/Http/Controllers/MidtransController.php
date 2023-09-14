<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Midtrans\CallbackService;

class MidtransController extends Controller
{
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;
 
    public function receive(CallbackService $callback)
    {
        $callback->updateOrder();
    }

    public function success()
    {
        return view('transactionShow');
    }
}