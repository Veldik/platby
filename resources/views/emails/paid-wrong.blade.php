@extends('emails.template')

@section('title')
    Platba přijata
@endsection

@section('content')
    <div>
        Zdravím, <br>
        díky moc za zaplacení, akorát že vůbec! Poslal si špatnou částku k platbě <b>{{ $payment['title'] }}</b>.<br>
        Měl si mi poslat <b>{{ $payment['amount'] }} CZK</b>, ale poslal jsi <b>{{ $payment['realamount'] }} CZK</b>.<br>
        Prosím, příště si to zkontroluj. Děkuji.<br>
        Ozvu se ti s řešením problému. <br>
    </div>
@endsection
