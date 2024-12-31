<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $merchantId = $request->input('merchantId');
        $productId = $request->input('id');
        $productName = $request->input('name');
        $productPrice = $request->input('price');
        $quantity = $request->input('quantity', 1);
        $img = $request->input('productImage');

        $cart = session()->get('cart', []);

        if (!empty($cart)) {
            // Ambil merchantId di keranjang
            $currentMerchantId = reset($cart)['merchantId'];

            //reset keranjang
            if ($currentMerchantId !== $merchantId) {
                $cart = [];
            }
        }

        //sudah ada di cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            //produk baru ke cart
            $cart[$productId] = [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity,
                'merchantId' => $merchantId,
                'image' => $img,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'cart' => $cart,
        ]);
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang belanja Anda kosong.');
        }

        if (!empty($cart)) {
            // Ambil merchantId
            $firstProduct = reset($cart);
            $merchantId = $firstProduct['merchantId'] ?? null;
        }

        // Hit API Merchant
        $client = new Client();
        $responseMerchant = $client->request('GET', 'https://api.klajek.com/api/merchants');
        $dataMerchant = json_decode($responseMerchant->getBody()->getContents(), true);
        $merchant = collect($dataMerchant['data'])->firstWhere('id', $merchantId);

        $cartCount = count($cart);

        return view('home-page/cart', compact('cart', 'merchant'), ['cartCount' => $cartCount]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            
            session()->put('cart', $cart);

            $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];

            $grandTotal = 0;
            foreach ($cart as $item) {
                $grandTotal += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'itemTotal' => number_format($itemTotal, 0, ',', '.'),
                'grandTotal' => number_format($grandTotal, 0, ',', '.')
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function checkout()
    {   
        session()->forget('cart');

        return view('home-page.checkout', ['cartCount' => '0']);
    }
    
}
