<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index() {

        $products = Product::where('is_featured', 'Yes')
                            ->orderBy('id','ASC')
                            ->where('status',1)
                            ->take(8)
                            ->get();
                            
        $data['featuredProducts'] = $products;

        $latestProducts = Product::orderBy('id', 'DESC')
                            ->where('status',1)
                            ->take(8)
                            ->get();

        $data['latestProducts'] = $latestProducts;
        return view ('front.home', $data);
    }

    public function addToWishlist(Request $request) {

    if (Auth::check() == false) {

        session(['url.intended' => url ()->previous()]);

        return response()->json([
            'status' => false
        ]);
    }

    $product = Product::where('id',$request->id)->first();

    if ($product == null) {
        return response()->json([
            'status' => false, // Change to false because the product was not found
            'message' => 'Product Not Found'
        ]);
    }

    $wishlist = Wishlist::updateOrCreate(
        [
            'user_id' => Auth::user()->id,
            'product_id' => $request->id,
        ],
        [
            'user_id' => Auth::user()->id,
            'product_id' => $request->id,
        ]
    );

    if ($wishlist->wasRecentlyCreated) {
        // Wishlist item was created, product added successfully
        return response()->json([
            'status' => true,
            'message' => '<div class="alert alert-success"><strong>"'.$product->title.'"</strong> Added in Your Wishlist Successfully</div>'
        ]);
    } else {
        // Wishlist item already exists, product is already in the wishlist
        return response()->json([
            'status' => false, // Change to false because the product is already in the wishlist
            'message' => '<div class="alert alert-info"><strong>"'.$product->title.'"</strong> Already in Wishlist</div>'
        ]);
    }
}

    public function page($slug) {
        $page = Page::where('slug',$slug)->first();
        if($page == null) {
            abort(404);
        }
        return view('front.page',[
            'page'=>$page
        ]);
        //dd($page);

    }

    public function sendContactEmail(Request $request) {
       $validator = Validator::make($request->all(),[
            'name' =>'required',
            'email' => 'required|email',
            'subject' => 'required|min:10'
        ]);

        if ($validator->passes()) {
            
            // Kirim Email

            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'mail_subject' => 'You have received a contact email'
            ];

            $admin = User::where('id',1)->first();

            Mail::to($admin->email)->send(new ContactEmail($mailData));

            session()->flash('success','Thanks for contacting us, we will get back to you soon.');

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