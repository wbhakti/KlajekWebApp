<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('sb-admin-2/dashboard');
    }

    public function MasterMerchant()
    {
        return view('sb-admin-2/mastermerchant');
    }

    public function MasterMenu()
    {
        return view('sb-admin-2/mastermenu');
    }

    public function MasterKategori()
    {
        return view('sb-admin-2/masterkategori');
    }

    public function logout(Request $request)
    {
        // Menghapus semua data dari sesi
        $request->session()->flush();
        return redirect()->route('Index');
    }
    
}
