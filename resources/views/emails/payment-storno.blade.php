@extends('emails.template')

@section('title')
    Stornována platba
@endsection

@section('content')
    <div>
        Zdravím, <br>
        nejspíše došlo k chybě a platba byla musela být stornována, tudíž ji neplaťte!<br>
        <br>
        <b>Podrobnosti stornované platby:</b><br>
        Název: <b>{{ $payment["title"] }}</b><br>
        Variabilní symbol: <b>{{ $payment['variable_symbol'] }}</b><br>
        Částka: <b>{{ str_replace(".", ",", $payment['amount']) }} CZK</b><br>
    </div>
@endsection
