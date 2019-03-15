@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4">{{trans_choice('order.count', $orders->count())}}</th>
                </tr>
                <tr>
                    <th>{{__('order.fields.number')}}</th>
                    <th>{{trans_choice('product.product', 2)}}</th>
                    <th>{{__('order.fields.value')}}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="{{route('order.show', $order->ID_ZAMOWIENIA)}}">{{$order->NUMER}}</a></td>
                        <td>
                            <table class="table table-borderless table-sm">
                                @foreach($order->pozycje as $pozycja)
                                    <tr>
                                        <td><a href="{{route('product.show', $pozycja->artykul->ID_ARTYKULU)}}" target="_blank">{{$pozycja->artykul->NAZWA_CALA}}</a><br/><small class="text-muted">{{$pozycja->artykul->KOD_KRESKOWY ?: $pozycja->artykul->ID_ARTYKULU}}</small></td>
                                        <td>{{round($pozycja->ZAMOWIONO)}} {{$pozycja->artykul->jednostka->SKROT}}</td>
                                        <td>{{number_format($pozycja->CENA_BRUTTO, 2, ',', ' ')}} zł<br/><small class="text-muted">{{number_format($pozycja->CENA_NETTO, 2, ',', ' ')}} zł</small></td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td class="text-right">{{number_format($order->WARTOSC_BRUTTO, 2, ',', ' ')}} zł<br/><small class="text-muted">{{number_format($pozycja->WARTOSC_NETTO, 2, ',', ' ')}} zł</small></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$orders->links()}}
    </div>
@endsection
