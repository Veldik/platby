@props([
    'payment',
    'message'
])

<h3>{{$payment['title']}}</h3>
<p>
    {{$payment['description']}}
</p>
<b>Číslo účtu:</b> {{ $payment["account_number"] }}<br/>
<b>Variabilní symbol:</b> {{ $payment['variable_symbol'] }}<br/>
<b>Částka:</b> {{ $payment['amount'] }}<br/>
<img alt="qrcode" height="auto"
     src="{{ $message->embed($payment['qr_code']) }}"
     width="300" height="300" alt="QR Platba"/>
