@extends('emails.template')

@section('title')
    Kredit přičten
@endsection

@section('content')
    <div>
        Ahoj! <br/>

        Právě ti byl přičten kredit v hodnotě {{ $data["amount"] }}. Nyní máš na kreditovém účtu celkem {{ $data["payer"]["credit"] }}. <br/>

        Přeji hezký den!
    </div>
@endsection
