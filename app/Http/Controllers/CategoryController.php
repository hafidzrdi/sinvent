<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(){
        $getcategory = Kategori::all();
        // $getbarang = Barang::all();
        // echo $getcategory[1]->deskripsi;
        // // br
        // echo $getcategory[0]->deskripsi;
        // return $getbarang;
        return view('v_kategori.demo', compact('getcategory'));
        // return view ('layouts.master');
    }
}