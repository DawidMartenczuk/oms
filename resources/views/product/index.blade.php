@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4">{{trans_choice('product.count', $products->total())}} ({{($products->currentPage() - 1) * $products->perPage() + 1}} - {{$products->currentPage() * $products->perPage()}})</th>
                </tr>
                <tr>
                    <th>{{__('product.fields.name')}}</th>
                    <th>{{__('product.availability.amount')}}</th>
                    <th>{{__('product.fields.price')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->NAZWA_CALA}}<br/><small class="text-muted">{{$product->PRODUCENT}}</small></td>
                        <td>{{$product->amount()}}</td>
                        <td>{{number_format($product->cenaDetaliczna()->first()->CENA_NETTO, 2)}} zł</td>
                        <td class="text-right"><a class="btn btn-primary" href="{{route('product.show', $product->ID_ARTYKULU)}}">{{__('resource.actions.view')}}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$products->links()}}
    </div>
@endsection
