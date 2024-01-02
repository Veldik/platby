@extends('emails.template')

@section('title')
    Obnovení hesla
@endsection

@section('content')
    <div>
        Ahoj!<br/>

        Tento e-mail jsi obdržel, protože jsme obdrželi žádost o změnu hesla pro tvůj účet. <br/> <br/>
        <a href="{{config('app.fe_url').'/auth/reset-password/'.$token}}"
           style="display: inline-block; background: #f8ea7e; color: #000000; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 19px; margin: 0; text-decoration: none; text-transform: uppercase; padding: 8px 12px; mso-padding-alt: 0px; border-radius: 10px;"
           target="_blank"> Obnovit heslo </a> <br/> <br/>
        Přeji hezký den!
    </div>
@endsection
