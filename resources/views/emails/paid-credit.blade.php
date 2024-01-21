@extends('emails.template')

@section('title')
    Zaplaceno pomocí kreditu
@endsection

@section('content')
    <div>
        Ahoj! </br>

        Chtěl jsem ti dát vědět, že jsme ti strhli kredit ve výši {{ $data["credit"] }} za zaplacení {{ $data["title"] }}. <br/>

        Tvůj aktuální zůstatek kreditů činí {{ $data["payer"]["credit"] }}. </br>

        Přeji hezký den!
    </div>
@endsection
