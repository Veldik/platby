@extends('emails.template')

@section('title')
    Výzva k platbě
@endsection

@section('content')
    <div>
        Ahoj! <br/>

        Posílám ti podrobnosti k zaplacení platby. <br/>
        <br/>
        <b>Podrobnosti platby:</b> <br>
        Číslo účtu: <b>{{ $payment["account_number"] }}</b><br>
        Variabilní symbol: <b>{{ $payment['variable_symbol'] }}</b><br>
        Částka: <b>{{ $payment['amount'] }}</b><br>
        <img alt="qrcode" height="auto"
             src="{{ $message->embed($payment['qr_code']) }}"
             width="300" height="300" alt="QR Platba"/>
        <br/>
        Víš, že se můžeš podívat na přehled všech svých plateb nebo předplatit kredity na další platby? Přehled plateb najdeš na <a href="{{ config('app.fe_url') }}">tomto odkazu</a>. <br/>
        <br/>
        Přeji hezký den!
    </div>
@endsection
