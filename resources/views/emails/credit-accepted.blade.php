@extends('emails.template')

@section('title')
    Kredit přičten
@endsection

@section('content')
    <div>
        Zdravím, <br>
        byl ti přičten kredit v hodnotě <b>{{ $data["amount"] }} CZK</b>.<br>
        Momentálně máš na účtu <b>{{ $data["payer"]["credit"] }} CZK</b>.<br>
    </div>
@endsection
