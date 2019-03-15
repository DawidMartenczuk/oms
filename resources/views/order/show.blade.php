@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>{{trans_choice('order.order', 1)}} {{$order->NUMER}} <span class="badge badge-primary">{{__('order.status.'.$order->STAN_REALIZ)}}</span></h3>

        <h5 class="mt-5">{{__('order.info')}}</h5>
        <div class="row mt-5">
            <div class="col-12 col-md-6">
                {{__('order.fields.number')}}: {{$order->NUMER}}<br/>
                {{__('order.fields.date')}}: {{$order->date()->toDateString()}}<br/>
                {{__('order.fields.status')}}: {{__('order.status.'.$order->STAN_REALIZ)}}<br/>
                {{__('order.fields.value')}}: {{number_format($order->WARTOSC_BRUTTO, 2, ',', ' ')}} zł <span class="text-muted">{{number_format($order->WARTOSC_NETTO, 2, ',', ' ')}} zł</spansmall>
            </div>
            <div class="col-12 col-md-6">
                {{$order->kontakt->IMIE}} {{$order->kontakt->NAZWISKO}}<br/>
                {{$order->kontakt->TYTUL}}@if($order->kontakt->TYTUL && $order->kontakt->STANOWISKO), @endif{{$order->kontakt->STANOWISKO}}@if($order->kontakt->TYTUL || $order->kontakt->STANOWISKO)<br/>@endif
                @if($order->kontakt->TEL)<i class="fas fa-phone"></i> {{$order->kontakt->TEL}}@endif @if($order->kontakt->TEL && $order->kontakt->TEL_KOM), @endif @if($order->kontakt->TEL_KOM)<i class="fas fa-phone"></i> {{$order->kontakt->TEL_KOM}}@endif @if($order->kontakt->TEL || $order->kontakt->TEL_KOM)<br/>@endif
                @if($order->kontakt->E_MAIL)<i class="fas fa-envelope"></i> {{$order->kontakt->E_MAIL}}@endif @if($order->kontakt->E_MAIL && $order->kontakt->FAX), @endif @if($order->kontakt->FAX)Fax: {{$order->kontakt->FAX}}@endif
            </div>
        </div>

        <h5 class="mt-5">{{trans_choice('product.product', 2)}} <span class="badge badge-primary">{{trans_choice('product.count', $order->pozycje()->count())}}</span></h5>
        <table class="table">
            @foreach($order->pozycje as $pozycja)
                <tr>
                    <td><a href="{{route('product.show', $pozycja->artykul->ID_ARTYKULU)}}" target="_blank">{{$pozycja->artykul->NAZWA_CALA}}</a><br/><small class="text-muted">{{$pozycja->artykul->KOD_KRESKOWY ?: $pozycja->artykul->ID_ARTYKULU}}</small></td>
                    <td>{{round($pozycja->ZAMOWIONO)}} {{$pozycja->artykul->jednostka->SKROT}}</td>
                    <td>{{number_format($pozycja->CENA_BRUTTO, 2, ',', ' ')}} zł<br/><small class="text-muted">{{number_format($pozycja->CENA_NETTO, 2, ',', ' ')}} zł</small></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><b>{{__('order.fields.value')}}</b></td>
                <td>{{number_format($order->WARTOSC_BRUTTO, 2, ',', ' ')}} zł<br/><small class="text-muted">{{number_format($order->WARTOSC_NETTO, 2, ',', ' ')}} zł</small></td>
            </tr>
        </table>

        <h5 class="mt-5">{{trans_choice('delivery.delivery', 2)}} <span class="badge badge-primary">{{trans_choice('delivery.count', $order->dostawy()->count())}}</span></h5>
        <table class="table">
            <thead>
                <tr>
                    <th>{{__('delivery.fields.id')}}</th>
                    <th>{{__('delivery.fields.method')}}</th>
                    <th>{{__('address.fields.country')}}</th>
                    <th>{{trans_choice('address.address', 1)}}</th>
                    <th>{{__('address.fields.business')}}</th>
                    <th>{{__('address.fields.recipient')}}</th>
                    <th>{{__('address.fields.phone')}}</th>
                    <th>{{__('delivery.fields.status')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->dostawy as $dostawa)
                    <tr>
                        <td>{{$dostawa->ID_DOSTAWY}}</td>
                        <td>{{$dostawa->forma->NAZWA}}</td>
                        <td>{{$dostawa->miejsce->kraj->NAZWA}}</td>
                        <td>
                            {{$dostawa->miejsce->ULICA_LOKAL}}<br/>
                            {{$dostawa->miejsce->KOD_POCZTOWY}} {{$dostawa->miejsce->MIEJSCOWOSC}}<br/>
                        </td>
                        <td>
                            @if($dostawa->miejsce->FIRMA)
                                {{$dostawa->miejsce->FIRMA}}<br/>
                            @endif
                        </td>
                        <td>
                            @if($dostawa->miejsce->ODBIORCA)
                                {{$dostawa->miejsce->ODBIORCA}}<br/>
                            @endif
                        </td>
                        <td>
                            @if($dostawa->miejsce->TEL)
                                <i class="fas fa-phone"></i> {{$dostawa->miejsce->TEL}}<br/>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{$dostawa->ODEBRANO ? 'success' : 'danger'}}">{{__('delivery.fields.status')}}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
