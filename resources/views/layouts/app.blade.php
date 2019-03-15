<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="{{asset('front/1.0/css/app.min.css')}}" >
        <title>{{env('APP_NAME')}}</title>

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-5">
            <div class="container">
                <a class="navbar-brand pb-3" href="{{route('home')}}">{{env('APP_NAME')}}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav pb-3 mr-auto">
                        <li class="nav-item @if(Route::getCurrentRoute()->getActionName() == 'home') active @endif "><a class="nav-link" href="{{route('home')}}">{{__('layout.nav.home')}}</a></li>
                    </ul>
                    @if(is_array(session('cart')) && count(session('cart')) > 0)
                        <ul class="navbar-nav pb-3 pr-3">
                            <li><a href="{{route('cart.index')}}" class="btn btn-outline-primary"><i class="fa fa-shopping-basket"></i> &nbsp; {{number_format(\App\Http\Controllers\CartController::sum(), 2)}} zł</a> </li>
                        </ul>
                    @endif
                    <ul class="navbar-nav pb-3 pr-3">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('login')}}">{{__('auth.login')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('register')}}">{{__('auth.register')}}</a>
                            </li>
                        @else
                            <li><a href="{{route('order.index')}}" class="btn btn-outline-dark"><i class="fas fa-user-circle"></i> &nbsp; {{@Auth::user()->name}}</a></li>
                        @endguest
                    </ul>
                </div>
                <form class="form-inline my-2 my-lg-0">
                    <div class="input-group mb-3">
                        <input name="q" type="text" class="form-control" placeholder="{{__('product.actions.search')}}" aria-label="{{__('product.actions.search')}}" aria-describedby="global-search-button" @if(request()->has('q')) value="{{request()->input('q')}}" @endif>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="global-search-button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </nav>
        @yield('content')

        <script type="text/javascript" src="{{asset('front/1.0/js/bootstrap.min.js')}}"></script>
        @stack('scripts')
    </body>
</html>