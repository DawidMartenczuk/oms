<?php

namespace App\Http\Controllers;

use App\WFMAG\Artykul;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = \App\WFMAG\Artykul::sellable()->available()->detal();
        if($request->has('q')) {
            $products->where('NAZWA_CALA', 'LIKE', sprintf('%%%s%%', $request->input('q')));
        }
        $products = $products->paginate(10);
        return view('product.index', ['products'=>$products]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WFMAG\Artykul  $artykul
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Artykul $product)
    {
        return view('product.show', ['product'=>$product]);
    }
}
