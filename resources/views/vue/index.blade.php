@extends('app')

@section('content')
    <section>
        @if (Route::is('products.vue'))
            <div id="app"></div>
        @endif
    </section>
@endsection