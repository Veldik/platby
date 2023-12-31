@extends('emails.template')

@section('title')
    Zaplaťte prosím
@endsection

@section('content')
    <div>
        Zdravím, <br>
        máte neuhrazenou platbu. Prosím zaplaťte. <br>
        <br>
        <b>Podrobnosti:</b> <br>
        Číslo účtu: <b>{{ $payment["account_number"] }}</b><br>
        Variabilní symbol: <b>{{ $payment['variable_symbol'] }}</b><br>
        Částka: <b>{{ str_replace(".", ",", $payment['amount']) }} CZK</b><br>
        <img alt="qrcode" height="auto"
             src="{{ $message->embed($payment['qr_code']) }}"
             width="300" height="300" alt="QR Platba"/>
    </div>
@endsection
