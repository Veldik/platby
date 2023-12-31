@extends('emails.template')

@section('title')
    Změna hesla
@endsection

@section('content')
    <div>
        Zdravím, <br>
        Tento e-mail jsi obdržel, protože jsme obdrželi tvoji žádost o změnu hesla pro tvůj účet.
    </div>
    <tr>
        <td align="left" vertical-align="middle"
            style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                   style="border-collapse:separate;line-height:100%;">
                <tbody>
                <tr>
                    <td align="center" bgcolor="#2e58ff" role="presentation"
                        style="border:none;border-radius:30px;cursor:auto;mso-padding-alt:10px 25px;background:#ffee2e;"
                        valign="middle">
                        <a href="{{config('app.fe_url').'/auth/reset-password/'.$token}}"
                           style="display: inline-block; background: #fae74f; color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: bold; line-height: 30px; margin: 0; text-decoration: none; text-transform: uppercase; padding: 10px 25px; mso-padding-alt: 0px; border-radius: 30px;"
                           target="_blank"> Obnovit heslo </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </div>
@endsection
