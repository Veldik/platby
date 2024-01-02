@extends('emails.template')

@section('title')
    Obnovení hesla
@endsection

@section('content')
    <div>
        Ahoj!<br/>

        Tento e-mail jsi obdržel, protože jsme obdrželi žádost o změnu hesla pro tvůj účet. <br/>
        <a href="{{config('app.fe_url').'/auth/reset-password/'.$token}}"
           style="display: inline-block; background: #e7d114; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: bold; line-height: 30px; margin: 0; text-decoration: none; text-transform: uppercase; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 30px;"
           target="_blank"> Obnovit heslo </a>
        Přeji hezký den!
    </div>
@endsection
