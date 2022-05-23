<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model\Product;
use App\Http\Controllers\Controller;

class BarcodeController extends Controller
{
    public function Barcode(){
        $products = Product::select()->get();
        return view('products.barcode.index', compact('products'));
    }
}
