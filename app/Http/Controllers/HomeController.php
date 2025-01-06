<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index()
    {
        try {
            // Hit API Merchant
            $client = new Client();
            $responseMerchant = $client->request('GET', 'https://api.klajek.com/api/merchants');
            $dataMerchant = json_decode($responseMerchant->getBody()->getContents(), true);

            // Ambil data cart dari session
            $cart = session()->get('cart', []);
            $cartCount = count($cart);

            return view('home-page/index', [
                'restoran' => $dataMerchant,
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal memuat data merchant: ' . $e->getMessage());
            abort(500);
        }
        
    }

    public function petunjuk()
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        return view('home-page/petunjuk', [
            'cartCount' => $cartCount
        ]);
    }

    public function contact()
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        return view('home-page/contact', [
            'cartCount' => $cartCount
        ]);
    }

    public function mitra()
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        return view('home-page/registrasi_mitra', [
            'cartCount' => $cartCount
        ]);
    }

}
