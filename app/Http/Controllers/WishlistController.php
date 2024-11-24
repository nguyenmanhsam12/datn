<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
        public function index()
        {
        
            $wishlists = auth()->user()->wishlists()->with('product')->paginate(12); 

            return view('client.pages.wishlist', compact('wishlists'));
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
