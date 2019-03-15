<?php

namespace App\Http\Controllers;

use App\WFMAG\Artykul;
use Illuminate\Http\Request;

use DB;

class CartController extends Controller
{
    /**
     * Display cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = static::products()->get();
        return view('cart.index', ['products'=>$products]);
    }
    /**
     * Confirm cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = (int)DB::connection('wfmag')->select(DB::raw('SELECT round(cast(getdate() as real),0,1)+36163 AS date'))[0]->date;
        if(!$request->input('contact.ID')) {
            $contact = new \App\WFMAG\Kontrahent\Kontakt;
            foreach($request->input('contact') as $k=>$v) {
                if(!$v) {
                    continue;
                }
                if($k == 'ID') {
                    continue;
                }
                $contact->$k = $v;
            }
            $contact->ID_KONTRAHENTA = \Auth::user()->kontrahent->ID_KONTRAHENTA;
            $contact->RODO_DATA = $date;
            $contact->save();
        }
        else {
            $contact = \App\WFMAG\Kontrahent\Kontakt::findOrFail($request->input('contact.ID'));
        }

        if(!$request->input('bill.ID')) {
            $bill = new \App\WFMAG\Kontrahent\Adres;
            foreach($request->input('bill') as $k=>$v) {
                if(!$v) {
                    continue;
                }
                if(in_array($k, ['ID', 'method'])) {
                    continue;
                }
                $bill->$k = $v;
            }
            $bill->ID_KONTRAHENTA = \Auth::user()->kontrahent->ID_KONTRAHENTA;
            $bill->DATA_OD = $date;
            $bill->RODO_DATA = $date;
            $bill->save();
        }
        else {
            $bill = \App\WFMAG\Kontrahent\Adres::findOrFail($request->input('bill.ID'));
        }

        if(!$request->input('delivery.ID')) {
            $delivery = new \App\WFMAG\Kontrahent\MiejsceDostawy;
            foreach($request->input('delivery') as $k=>$v) {
                if(!$v) {
                    continue;
                }
                if(in_array($k, ['ID', 'method'])) {
                    continue;
                }
                $delivery->$k = $v;
            }
            $delivery->ID_KONTRAHENTA = \Auth::user()->kontrahent->ID_KONTRAHENTA;
            $delivery->RODO_DATA = $date;
            $delivery->save();
        }
        else {
            $delivery = \App\WFMAG\Kontrahent\MiejsceDostawy::findOrFail($request->input('delivery.ID'));
        }

        $data = [
            'kontrahent'    => \Auth::user()->kontrahent,
            'kontakt'       => $contact,
            'invoicing'     => $request->input('bill.method'),
            'adres'         => $bill,
            'delivery'      => \App\WFMAG\FormaDostawy::findOrFail($request->input('delivery.method')),
            'miejsce'       => $delivery,
            'payment'       => \App\WFMAG\FormaPlatnosci::findOrFail($request->input('payment')),
            'articles'      => session('cart')
        ];

        $insertedOrder = \App\WFMAG\Zamowienie::create($data);

        session(['cart'=>NULL]);

        if(is_array($insertedOrder) && array_key_exists('id', $insertedOrder)) {
            return redirect()->route('order.show', $insertedOrder['id']);
        }
        return abort(406);
    }

    /**
     * Update product count in cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WFMAG\Artykul  $artykul
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artykul $cart)
    {
        session(['cart.'.$cart->ID_ARTYKULU => $request->input('amount')]);
        session(['cart' => array_filter(session('cart') ?: [], function($v) { return $v > 0; })]);
        return redirect()->route('cart.index');
    }

    /**
     * Remove the specified product from cart.
     *
     * @param  \App\WFMAG\Artykul  $artykul
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Artykul $cart)
    {
        return $this->update($request, $product);
    }

    /**
     * Get products in cart
     *
     * @return \Illuminate\Http\Artykul
     */
    public static function products() {
        return Artykul::whereIn('ID_ARTYKULU', array_keys(array_filter(session('cart') ?: [], function($v) { return $v > 0; })));
    }

    /**
     * Sum price of products in cart
     *
     * @return float
     */
    public static function sum() {
        $price = 0;
        foreach(static::products()->get() as $product) {
            $price += $product->cenaDetaliczna()->first()->CENA_BRUTTO * session('cart.'.$product->ID_ARTYKULU);
        }
        return $price;
    }
}
