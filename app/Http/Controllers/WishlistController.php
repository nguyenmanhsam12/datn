<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product')->paginate(12);

        DB::enableQueryLog();

        $topSellingProducts = \App\Models\Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(12)
            ->get();

        return view('client.pages.wishlist', compact('wishlists', 'topSellingProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $request->product_id]
        );

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $wishlist->delete();

        return redirect()->route('wishlist')->with('success', 'Wishlist item removed!');
    }
}
