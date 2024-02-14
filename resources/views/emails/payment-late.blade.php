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
            <x-payment :payment="$payment" :message="$message"/>
            @if(!$loop->last)
                <hr/>
            @endif
        @endforeach
        <br/>
        Přeji hezký den!
    </div>
@endsection
