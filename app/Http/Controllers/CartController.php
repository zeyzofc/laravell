<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request) {
        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Record Not Found'
            ]);
        }

        if (Cart::count() > 0) {
             
            $cartContent = Cart::content();
            $productAlreadyExist = false;

            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }
            }

            if ($productAlreadyExist == false) {
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '' ]);
                $status = true;
                $message = '<strong>'.$product->title.'</strong> added in your cart successfully.';
                session()->flash('success', $message);

            } else {
                $status = false;
                $message = $product->title.' already added in Cart';
            }


        } else {
            echo "Cart is Empty Now Adding a product in cart";
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '' ]);
            $status = true;
            $message = '<strong>'.$product->title.'</strong> added in your cart successfully.';
            session()->flash('success', $message);
        }

        return response()->json([
                'status' => $status,
                'message' => $message
            ]);
    }

    public function cart() {
        $cartContent = Cart::content();
        //dd($cartContent);
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }

    public function updateCart(Request $request) {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);
        //Check QTY Available in Stock
        if ($product->track_qty == 'Yes') {
            if ($qty <= $product->qty) {
                Cart::update($rowId, $qty);
                $message = 'Cart updated successfully';
                $status = true;
                session()->flash('success', $message);
            } else {
                $message = 'Requested qty ('.$qty.') not available in stock.';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            Cart::update($rowId, $qty);
                $message = 'Cart updated successfully';
                $status = true;
                session()->flash('success', $message);
        }
        
        
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);

    }

    public function deleteItem(Request $request) {

        $itemInfo = Cart::get($request->rowId);

        if($itemInfo == null) {
            $errorMessage = 'Item not found in cart';
            session()->flash('error', $errorMessage);

            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }

        Cart::remove($request->rowId);

        $message = 'Item removed from cart successfully';
        session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
    }

    public function checkout(){

        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        if (Auth::check() == false) {

            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
           
            return redirect()->route('account.login');
        }

        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();

        session()->forget('url.intended');

        $countries = Country::orderBy('name','ASC')->get();

        return view('front.checkout',[
            'countries' => $countries,
            'customerAddress' => $customerAddress
        ]);
    }

    public function processCheckout(Request $request) {
        
        // Langkah 1 Apply Validation

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Langkah 2 Save User Address

        $user = Auth::user();

        CustomerAddress::updateOrCreate (
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,

            ]
        );
         // Langkah 3 Store Data in Orders Table

         if ($request->payment_method == 'cod') {

            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(2,'.','');
            $grandTotal = $subTotal+$shipping;

            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $grandTotal;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->state = $request->state;
            $order->city = $request->city;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;
            $order->country_id = $request->country;
            $order->save();


        // Langkah 4 Store Order Item in Order Items Table

            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price*$item->qty;
                $orderItem->save();

            }

            session()->flash('success', 'You have successfully placed your order.');

            Cart::destroy();

            return response()->json([
                'message' => 'Order saved successfully',
                'orderId' => $order->id,
                'status' => true
            ]);

         } else {

         }
    }

    public function thankyou($id) {

        return view('front.thanks',[
            'id' => $id
        ]);
    }
}