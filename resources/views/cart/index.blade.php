@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="6">{{trans_choice('product.product', 2)}}</th>
                </tr>
                <tr>
                    <th>{{__('product.fields.name')}}</th>
                    <th>{{__('price.net')}}</th>
                    <th>{{__('price.gross')}}</th>
                    <th>{{__('product.availability.amount')}}</th>
                    <th>{{__('product.fields.price')}}</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->NAZWA_CALA}}<br/><small class="text-muted">{{$product->PRODUCENT}}</small></td>
                        <td>{{number_format($product->cenaDetaliczna()->first()->CENA_NETTO, 2)}} zł</td>
                        <td>{{number_format($product->cenaDetaliczna()->first()->CENA_BRUTTO, 2)}} zł</td>
                        <td><form action="{{route('cart.update', $product->ID_ARTYKULU)}}" method="POST">@csrf @method('PATCH')<input type="number" name="amount" class="form-control" step="{{$product->jednostka->PODZIELNA ? 0.0001 : 1}}" value="{{session('cart.'.$product->ID_ARTYKULU, 1)}}" min="{{$product->jednostka->PODZIELNA ? 0.0001 : 1}}" max="{{number_format($product->amount())}}" /></form></td>
                        <td>{{number_format($product->cenaDetaliczna()->first()->CENA_BRUTTO * session('cart.'.$product->ID_ARTYKULU), 2)}} zł</td>
                        <td class="text-right"><a class="btn btn-secondary" data-cart-edit="true">{{__('resource.actions.edit')}}</a></td>
                        <td class="text-right"><a class="btn btn-danger" data-cart-delete="true">{{__('resource.actions.destroy')}}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="bg-light py-5 mt-5">
        <div class="container">
            @guest
                <p class="lead text-center">{{__('auth.required')}}</p>

                <div class="text-center">
                    <a href="{{route('login')}}" class="btn btn-primary">{{__('auth.login')}}</a> &nbsp; 
                    <a href="{{route('register')}}" class="btn btn-dark">{{__('auth.register')}}</a>
                </div>
            @endguest
            @auth
                <form action="{{route('cart.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <h5>{{__('address.type.contact')}}</h5>
                            @if(Auth::user()->kontrahent && Auth::user()->kontrahent->kontakty()->count())
                                <div class="form-group"><select name="contact[ID]" data-address-selector="contact" class="form-control"><option value="" selected>{{__('resource.actions.select')}}</option> @foreach(Auth::user()->kontrahent->kontakty as $kontakt) <option data-address="{{$kontakt->toJson()}}" value="{{$kontakt->ID_KONTAKTU}}">{{$kontakt->IMIE}} {{$kontakt->NAZWISKO}}</option> @endforeach </select></div>
                            @endif
                            <div class="row form-group">
                                <div class="col-12 col-md-6"><input name="contact[IMIE]" type="text" class="form-control" id="contact_name" placeholder="{{__('contact.fields.name')}}" /></div>
                                <div class="col-12 col-md-6"><input name="contact[NAZWISKO]" type="text" class="form-control" id="contact_surname" placeholder="{{__('contact.fields.surname')}}" /></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-6"><input name="contact[TYTUL]" type="text" class="form-control" id="contact_title" placeholder="{{__('contact.fields.title')}}" /></div>
                                <div class="col-12 col-md-6"><input name="contact[STANOWISKO]" type="text" class="form-control" id="contact_office" placeholder="{{__('contact.fields.office')}}" /></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-6"><input name="contact[TEL]" type="text" class="form-control" id="contact_tel" placeholder="{{__('contact.fields.tel')}}" /></div>
                                <div class="col-12 col-md-6"><input name="contact[TEL_KOM]" type="text" class="form-control" id="contact_phone" placeholder="{{__('contact.fields.phone')}}" /></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-12 col-md-6"><input name="contact[FAX]" type="text" class="form-control" id="contact_fax" placeholder="{{__('contact.fields.fax')}}" /></div>
                                <div class="col-12 col-md-6"><input name="contact[E_MAIL]" type="text" class="form-control" id="contact_email" placeholder="{{__('contact.fields.email')}}" /></div>
                            </div>
                            <h5>{{__('cart.invoicing.header')}}</h5>
                            <div class="form-group">
                                <select name="bill[method]" class="form-control">
                                    <option value="1">{{__('cart.invoicing.1')}}</option>
                                    <option value="2">{{__('cart.invoicing.2')}}</option>
                                </select>
                            </div>
                            <h5>{{__('address.type.bill')}}</h5>
                            @if(Auth::user()->kontrahent && Auth::user()->kontrahent->adresy()->count())
                                <div class="form-group"><select name="bill[ID]" data-address-selector="bill" class="form-control"><option value="" selected>{{__('resource.actions.select')}}</option> @foreach(Auth::user()->kontrahent->adresy as $adres) <option data-address="{{$adres->toJson()}}" value="{{$adres->ID_ADRESY_KONTRAHENTA}}">{{$adres->ULICA_LOKAL}}, {{$adres->MIEJSCOWOSC}}</option> @endforeach </select></div>
                            @endif
                            <div class="row form-group">
                                <div class="col-12 col-md-8"><input name="bill[NAZWA_PELNA]" type="text" class="form-control" id="bill_business" placeholder="{{__('address.fields.business')}}" /></div>
                                <div class="col-12 col-md-4"><input name="bill[NIP]" type="text" class="form-control" id="bill_vat" placeholder="{{__('address.fields.vat')}}" /></div>
                            </div>
                            <div class="form-group"><input name="bill[ULICA_LOKAL]" type="text" class="form-control" id="bill_address" placeholder="{{__('address.fields.address')}}" /></div>
                            <div class="row form-group">
                                <div class="col-12 col-md-4"><input name="bill[KOD_POCZTOWY]" type="text" class="form-control" id="bill_code" placeholder="{{__('address.fields.code')}}" /></div>
                                <div class="col"><input name="bill[MIEJSCOWOSC]" type="text" class="form-control" id="bill_city" placeholder="{{__('address.fields.city')}}" /></div>
                            </div>
                            <div class="form-group"><input name="bill[WOJEWODZTWO]" type="text" class="form-control" id="bill_state" placeholder="{{__('address.fields.state')}}" /></div>
                            <div class="form-group"><input name="bill[POWIAT]" type="text" class="form-control" id="bill_county" placeholder="{{__('address.fields.county')}}" /></div>
                            <div class="form-group"><select name="bill[SYM_KRAJU]" class="form-control" id="bill_country"> @foreach(\App\WFMAG\Kraj::all() as $kraj) <option value="{{$kraj->SYM_KRAJU}}">{{$kraj->NAZWA}}</option> @endforeach </select></div>
                        </div>
                        <div class="col">
                            <h5>{{__('cart.delivery')}}</h5>
                            <div class="form-group">
                                <select name="delivery[method]" class="form-control">
                                    @foreach(\App\WFMAG\FormaDostawy::all() as $form)
                                        <option value="{{$form->ID_FORMY_DOSTAWY}}">{{$form->NAZWA}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <h5>{{__('address.type.delivery')}}</h5>
                            @if(Auth::user()->kontrahent && Auth::user()->kontrahent->miejscaDostawy()->count())
                                <div class="form-group"><select name="delivery[ID]" data-address-selector="delivery" class="form-control"><option value="" selected>{{__('resource.actions.select')}}</option> @foreach(Auth::user()->kontrahent->miejscaDostawy as $miejsceDostawy) <option data-address="{{$miejsceDostawy->toJson()}}" value="{{$miejsceDostawy->ID_MIEJSCA_DOSTAWY}}">{{$miejsceDostawy->ULICA_LOKAL}}, {{$miejsceDostawy->MIEJSCOWOSC}}</option> @endforeach </select></div>
                            @endif
                            <div class="form-group"><input name="delivery[FIRMA]" type="text" class="form-control" id="delivery_business" placeholder="{{__('address.fields.business')}}" /></div>
                            <div class="form-group"><input name="delivery[ODBIORCA]" type="text" class="form-control" id="delivery_recipient" placeholder="{{__('address.fields.recipient')}}" /></div>
                            <div class="form-group"><input name="delivery[ULICA_LOKAL]" type="text" class="form-control" id="delivery_address" placeholder="{{__('address.fields.address')}}" /></div>
                            <div class="row form-group">
                                <div class="col-12 col-md-4"><input name="delivery[KOD_POCZTOWY]" type="text" class="form-control" id="delivery_code" placeholder="{{__('address.fields.code')}}" /></div>
                                <div class="col"><input name="delivery[MIEJSCOWOSC]" type="text" class="form-control" id="delivery_city" placeholder="{{__('address.fields.city')}}" /></div>
                            </div>
                            <div class="form-group"><select name="delivery[SYM_KRAJU]" class="form-control" id="delivery_country"> @foreach(\App\WFMAG\Kraj::all() as $kraj) <option value="{{$kraj->SYM_KRAJU}}">{{$kraj->NAZWA}}</option> @endforeach </select></div>
                            <div class="form-group"><input name="delivery[TEL]" type="text" class="form-control" id="delivery_phone" placeholder="{{__('address.fields.phone')}}" /></div>
                            <h5>{{__('cart.payment')}}</h5>
                            <div class="form-group">
                                <select name="payment" class="form-control">
                                    @foreach(\App\WFMAG\FormaPlatnosci::all() as $form)
                                        <option value="{{$form->ID_FORMY}}">{{$form->NAZWA}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="float-left">
                                <a href="{{route('home')}}" class="btn btn-dark">{{__('cart.actions.continue')}}</a>
                            <button type="reset" class="btn btn-light">{{__('cart.actions.reset')}}</button>
                        </div>

                        <div class="float-right">
                            <button class="btn btn-primary">{{__('cart.actions.order')}}</button>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{asset('front/1.0/js/cart.min.js')}}"></script>
@endpush
