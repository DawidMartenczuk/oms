@extends('layouts.app')

@section('content')
    <div class="container">
        @php
            $articles = \App\WFMAG\Artykul::available()->detal()->paginate(10);    
        @endphp
        <table class="table">
            <thead>
                <tr>
                    <th>{{trans_choice('product.product', 2)}}</th>
                </tr>
                <tr>
                    <th>{{__('product.fields.name')}}</th>
                    <th>{{__('product.availability.amount')}}</th>
                    <th>{{__('product.fields.price')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{$article->NAZWA_CALA}}</td>
                        <td>{{$article->amount()}}</td>
                        <td>{{$article->cenaDetaliczna()->first()->CENA_NETTO}}</td>
                        <td class="text-right"><a class="btn btn-primary">{{__('resource.actions.view')}}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$articles->links()}}
    </div>
@endsection
