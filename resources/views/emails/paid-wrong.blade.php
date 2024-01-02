@extends('emails.template')

@section('title')
    Platba přijata
@endsection

@section('content')
    <div>
        Ahoj! <br/>

        Děkuji za tvoji platbu. Všiml jsem si, že došlo k malému nedorozumění s částkou k platbě za {{ $payment['title'] }}. <br/>

        Měl jsi mi poslat {{ $payment['amount'] }}, ale ve skutečnosti jsi poslal {{ $payment['realamount'] }}. Může se to stát, ale prosím, příště si to zkontroluj. <br/>

        Neboj, společně najdeme řešení tohoto problému. Ozvu se ti co nejdříve s možnými kroky. <br/>

        Přeji hezký den!
    </div>
@endsection
