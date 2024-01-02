@extends('emails.template')

@section('title')
    Oznámení o nezaplacených platbách
@endsection

@section('content')
    <div>
        Ahoj! <br/>

        jsem velmi smutný, že došlo k odeslání tohoto emailu. Bohužel už delší dobu nemohu zaznamenat žádnou platbu od tebe, i přestože ji očekávám. <br/>

        Níže přikládám seznam plateb, které je potřeba uhradit. <br/>

        @foreach($payments as $payment)
            <h3>{{$payment['title']}}</h3>
            <b>Číslo účtu:</b> {{ $payment["account_number"] }}<br/>
            <b>Variabilní symbol:</b> {{ $payment['variable_symbol'] }}<br/>
            <b>Částka:</b> {{ $payment['amount'] }}<br/>
            <img alt="qrcode" height="auto"
                 src="{{ $message->embed($payment['qr_code']) }}"
                 width="300" height="300" alt="QR Platba"/>
        @endforeach
        <br/>
        Přeji hezký den!
    </div>
@endsection
