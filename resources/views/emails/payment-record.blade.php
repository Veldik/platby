@extends('emails.template')

@section('title')
    Výzva k platbě
@endsection

@section('content')
    <div>
        Ahoj! <br/>

        Posílám ti podrobnosti k zaplacení platby. <br/>
        <br/>
        <x-payment :payment="$payment" :message="$message"/>
        <br/>
        Přeji hezký den!
    </div>
@endsection
