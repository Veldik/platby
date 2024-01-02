@extends('emails.template')

@section('title')
    Automaticky zaplaceno pomocí kreditu
@endsection

@section('content')
    <div>
        Ahoj! </br>

        Chtěl jsem ti dát vědět, že jsme ti strhli kredit ve výši {{ $data["credit"] }} za nákup {{ $data["title"] }}. <br/>

        Tvůj aktuální zůstatek kreditů činí {{ $data["payer"]["credit"] }}. </br>

        Přeji hezký den!
    </div>
@endsection
