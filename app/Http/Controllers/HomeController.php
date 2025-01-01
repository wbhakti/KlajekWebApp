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

    public function menu($id, Request $request)
    {
        $client = new Client();
        $dataKategori = [];
        $dataproduk = [];

        $reset = $request->query('reset');
        if ($reset === 'Y') {
            session()->forget('cart'); //hapus keranjang
        }

        // Ambil data cart dari session
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        // produk di keranjang dan merchantId berbeda
        if (!empty($cart)) {
            $currentMerchantId = reset($cart)['merchantId'];
            if ($currentMerchantId !== $id) {
                return back()->with([
                    'duplicate' => 'Keranjang Anda berisi produk dari resto lain. Keranjang akan dihapus jika Anda melanjutkan.',
                    'merchantNew' => $id,
                ]);
            }
        }

        try {
            // Hit API Kategori
            $responseKategori = $client->request('GET', 'https://api.klajek.com/api/category');
            $dataKategori = json_decode($responseKategori->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('Gagal memuat data kategori: ' . $e->getMessage());
        }

        try {
            // Hit API Produk
            $url = 'https://api.klajek.com/api/menus/' . $id;
            $responseProduk = $client->request('GET', $url);
            $dataproduk = json_decode($responseProduk->getBody()->getContents(), true);

            $kategori = $request->query('kategori');
            //dd($kategori);
            if (!empty($kategori)) {
                if($kategori == "all"){
                    $dataproduk = $dataproduk;
                }else{
                    $dataproduk['data'] = array_filter($dataproduk['data'], function ($item) use ($kategori) {
                        return isset($item['kategori']['kategori']) && $item['kategori']['kategori'] === $kategori;
                    });
                }
            }

        } catch (\Exception $e) {
            Log::error('Gagal memuat data produk: ' . $e->getMessage());
        }

        // Hit API Merchant
        $responseMerchant = $client->request('GET', 'https://api.klajek.com/api/merchants');
        $dataMerchant = json_decode($responseMerchant->getBody()->getContents(), true);
        $merchant = collect($dataMerchant['data'])->firstWhere('id', $id);

        return view('home-page/restoran', [
            'kategori' => $dataKategori, 
            'produk' => $dataproduk,
            'merchant' => $merchant,
            'cartCount' => $cartCount
        ]);
    }
}
