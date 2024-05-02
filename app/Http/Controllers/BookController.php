<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('products', compact('books'));
    }
    public function addBooktoCart($id)
    {
        $book = Book::findOrFail($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $book->name,
                "quantity" => 1,
                "price" => $book->price,
                "image" => $book->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Book has been added to cart!');
    }

    public function bookCart(Request $request){  

        $cart = $request->session()->get('cart', []);
        $totalPrice = $this->calculateTotalPrice($cart);
        return view('cart', compact('cart', 'totalPrice'));

    }
    private function calculateTotalPrice($cart)
    {
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return $totalPrice;
    }
    

    public function deleteProduct(Request $request){
            if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Book successfully deleted.');
        }
    }

    public function incrementCartItem(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
            $request->session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function decrementCartItem(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity'] -= 1;
            $request->session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
