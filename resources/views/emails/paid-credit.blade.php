@extends('emails.template')

@section('title')
    Automaticky zaplaceno pomocí kreditu
@endsection

@section('content')
    <div>
        Zdravím, <br>
        byl ti stržen kredit v hodnotě <b>{{ $data["credit"] }} CZK</b>.<br>
        Kreditem bylo zaplaceno <b>{{ $data["title"] }}</b>.<br>
        Momentálně máš na účtu <b>{{ $data["payer"]["credit"] }} CZK</b>.<br>
    </div>
@endsection
