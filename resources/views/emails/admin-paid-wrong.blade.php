@extends('emails.template')

@section('title')
    Platba přijata {{$payment['title']}}
@endsection

@section('content')
    <div>

        Ahoj! <br/>

        Chci tě informovat, že <b>{{ $payment['name'] }}</b> ti odeslal špatnou částku k platbě <b>{{ $payment['title'] }}</b>. Měl ti poslat <b>{{ $payment['amount'] }}</b>, ale v reálu ti dorazilo <b>{{ $payment['realamount'] }}</b>. Bude super, když se s ním spojíš a pokusíte se společně najít řešení této situace. <br/>

        Přeji hezký den!
    </div>
@endsection
