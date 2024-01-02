@extends('emails.template')

@section('title')
    Platba přijata
@endsection

@section('content')
    <div>
        Ahoj! <br/>

        Obdržel jsem platbu za <b>{{ $payment['title'] }}</b> v hodnotě <b>{{ $payment['amount'] }}</b>. <br/>

        Díky moc za zaplacení! <br/>

        Přeji hezký den!
    </div>
@endsection
