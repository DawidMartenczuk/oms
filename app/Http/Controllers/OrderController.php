<?php

namespace App\Http\Controllers;

use App\WFMAG\Artykul;
use Illuminate\Http\Request;

use App\WFMAG\Zamowienie;
use Auth;

class OrderController extends Controller
{
    /**
     * Display order list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('order.index', ['orders'=>Zamowienie::where('ID_KONTRAHENTA', Auth::user()->kontrahent->ID_KONTRAHENTA)->paginate(10)]);
    }

    /**
     * Display order details.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Zamowienie $order)
    {
        if($order->ID_KONTRAHENTA != Auth::user()->kontrahent->ID_KONTRAHENTA) {
            abort(401);
        }
        return view('order.show', ['order'=>$order]);
    }

}