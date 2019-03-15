@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>
            {{$product->NAZWA_CALA}}<br/>
            <small class="text-muted text-uppercase">{{$product->PRODUCENT}}</small>
        </h3>
        <hr/>
        <div class="row">
            <div class="col-12 col-md-6">
                {!!$product->OPIS!!}
                {!!$product->UWAGI!!}
                {!!$product->OSTRZEZENIE!!}
            </div>
            <div class="col">
                <table class="table table-sm">
                    <tr><th>{{__('product.fields.name')}}</th><td>{{$product->NAZWA_CALA}}</td></tr>
                    <tr><th>{{__('product.fields.manufacturer')}}</th><td>{{$product->PRODUCENT}}</td></tr>
                    <tr><th>{{__('product.fields.price')}} <small class="text-lowercase text-muted">{{__('price.net')}}</small></th><td>{{number_format($product->cenaDetaliczna()->first()->CENA_NETTO, 2)}}</td></tr>
                    <tr><th>{{__('product.fields.price')}} <small class="text-lowercase text-muted">{{__('price.gross')}}</small></th><th>{{number_format($product->cenaDetaliczna()->first()->CENA_BRUTTO, 2)}}</th></tr>
                    <tr><th>{{__('product.availability.amount')}}</th><td>{{number_format($product->amount(), $product->jednostka->PODZIELNA ? 4 : 0)}} {{$product->jednostka->SKROT}}</td></tr>
                    <tr><th>{{__('product.fields.code')}}</th><td>{{$product->INDEKS_PRODUCENTA ?: ($product->INDEKS_KATALOGOWY ?: $product->INDEKS_HANDLOWY)}}</td></tr>
                </table>
                @if($product->KOD_KRESKOWY)
                    {{__('product.fields.barcode')}}<br/>
                    {!!DNS1D::getBarcodeHTML($product->KOD_KRESKOWY, "EAN13")!!}
                @endif
                <form action="{{route('cart.update', $product->ID_ARTYKULU)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row mt-3 no-gutters">
                        <div class="col-6">
                            <input type="number" name="amount" class="btn btn-secondary btn-block btn-lg" step="{{$product->jednostka->PODZIELNA ? 0.0001 : 1}}" value="{{session('cart.'.$product->ID_ARTYKULU, 1)}}" min="{{$product->jednostka->PODZIELNA ? 0.0001 : 1}}" max="{{number_format($product->amount())}}" />
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-block btn-lg text-uppercase">{{__(session('cart.'.$product->ID_ARTYKULU) ? 'cart.actions.change' : 'resource.actions.buy')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
