@extends('emails.template')

@section('title')
    Platba přijata
@endsection

@section('content')
    <div>
        Zdravím, <br>
        díky moc za zaplacení <b>{{ $payment['title'] }}</b>.
    </div>
@endsection
