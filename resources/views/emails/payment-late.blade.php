@extends('emails.template')

@section('title')
    Oznámení o nezaplacených platbách
@endsection

@section('content')
    <div>
        Zdravím, <br>
        jsem velice smutný, že systém odeslal tento email. Bohužel jsem neobdržel už delší čas nějakou tu platbu.<br>
        <br>
        Přikládám seznam plateb, které je nutno doplatit.<br>

            @foreach($payments as $payment)
                    <h3>{{$payment['title']}}</h3>
                    <b>Číslo účtu:</b> {{ $payment["account_number"] }}<br>
                    <b>Variabilní symbol:</b> {{ $payment['variable_symbol'] }}<br>
                    <b>Částka:</b> {{ str_replace(".", ",", $payment['amount']) }} CZK<br>
                    <img alt="logo" height="auto"
                         src="{{ $message->embed($payment['qr_code']) }}"
                         width="300" height="300" alt="QR Platba"/>

            @endforeach

    </div>
@endsection
