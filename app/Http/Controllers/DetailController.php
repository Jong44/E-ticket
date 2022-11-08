<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detail;

class DetailController extends Controller
{
    public function index()
    {
        $detail = detail::with('user','kategori','pesanan')->get();
        return $detail;
    }
}
