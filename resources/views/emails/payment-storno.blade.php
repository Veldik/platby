@extends('emails.template')

@section('title')
    Stornována platba
@endsection

@section('content')
    <div>
        Ahoj! <br/>

        Vypadá to, že došlo k nějaké chybě a platba musela být stornována, takže ji, prosím, neplať. <br/>
        <br>
        <b>Podrobnosti stornované platby:</b><br>
        Název: <b>{{ $payment["title"] }}</b><br>
        Variabilní symbol: <b>{{ $payment['variable_symbol'] }}</b><br>
        Částka: <b>{{ $payment['amount'] }}</b><br>
        <br>
        Přeji hezký den!
    </div>
@endsection
