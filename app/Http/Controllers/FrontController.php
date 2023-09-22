<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

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
}