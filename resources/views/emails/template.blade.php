<!DOCTYPE html>
<html lang="cs" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <title> @yield('title') </title>
    <!--[if !mso]><!-- -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!--<![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }
    </style>
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if lte mso 11]>
    <style type="text/css">
        .mj-outlook-group-fix {
            width: 100% !important;
        }
    </style>
    <![endif]-->
    <style type="text/css">
        @media only screen and (min-width: 480px) {
            .mj-column-per-100 {
                width: 100% !important;
                max-width: 100%;
            }
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width: 480px) {
            table.mj-full-width-mobile {
                width: 100% !important;
            }

            td.mj-full-width-mobile {
                width: auto !important;
            }
        }
    </style>
    <style type="text/css">
        a,
        span,
        td,
        th {
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }
    </style>
</head>

<body style="background-color:#ffffff;">
<div
    style="display:none;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"> @yield('title') </div>
<div style="background-color:#ffffff;">
    <!--[if mso | IE]>
    <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
    >
        <tr>
            <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
    <![endif]-->
    <div style="margin:0px auto;max-width:600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
            <tbody>
            <tr>
                <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;text-align:center;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">

                        <tr>

                            <td
                                class="" style="vertical-align:top;width:600px;"
                            >
                    <![endif]-->
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                         style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;" width="100%">
                            <tbody>
                            <tr>
                                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                           style="border-collapse:collapse;border-spacing:0px;">
                                        <tbody>
                                        <tr>
                                            <td style="width:100px;">
                                                <a href="{{ config('app.fe_url') }}">

                                                    <img height="auto"
                                                         src="{{ $message->embed(public_path() . '/images/logo-white.png') }}"
                                                         style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:14px;"/>
                                                </a>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <div
                                        style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:24px;text-align:left;color:#434245;">
                                        <h1 style="margin: 0; font-size: 24px; line-height: normal; font-weight: bold;"> @yield('title') </h1>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--[if mso | IE]>
                    </td>

                    </tr>

                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--[if mso | IE]>
    </td>
    </tr>
    </table>

    <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
    >
        <tr>
            <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
    <![endif]-->
    <div style="margin:0px auto;max-width:600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
            <tbody>
            <tr>
                <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">

                        <tr>

                            <td
                                class="" style="vertical-align:top;width:600px;"
                            >
                    <![endif]-->
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                         style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;" width="100%">
                            <tbody>
                            <tr>
                                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <div
                                        style="font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;line-height:24px;text-align:left;color:#434245;">
                                        @yield('content')
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--[if mso | IE]>
                    </td>

                    </tr>

                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--[if mso | IE]>
    </td>
    </tr>
    </table>

    <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
    >
        <tr>
            <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
    <![endif]-->
    <div style="margin:0px auto;max-width:600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
            <tbody>
            <tr>
                <td style="direction:ltr;font-size:0px;padding:20px 0;padding-top:0;text-align:center;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">

                        <tr>

                            <td
                                class="" style="vertical-align:top;width:600px;"
                            >
                    <![endif]-->
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                         style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;" width="100%">
                            <tbody>
                            <tr>
                                <td style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <p style="border-top: dashed 1px lightgrey; font-size: 1px; margin: 0px auto; width: 100%;">
                                    </p>
                                    <!--[if mso | IE]>
                      <table
                         align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:dashed 1px lightgrey;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px"
                      >
                        <tr>
                          <td style="height:0;line-height:0;">
                            &nbsp;
                          </td>
                        </tr>
                      </table>
                    <![endif]-->
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                    <div
                                        style="font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;line-height:24px;text-align:left;color:#999999;">
                                        Systém, který ti zaslal tento e-mail, vytvořil <a
                                            href="https://thevelda.eu">Velda</a>.</div>
                                    <div
                                        style="font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;line-height:24px;text-align:left;color:#999999;">
                                        Projekt je open-source dostupný na <a
                                            href="https://github.com/veldik/platby"
                                        >Githubu</a>.
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--[if mso | IE]>
                    </td>

                    </tr>

                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--[if mso | IE]>
    </td>
    </tr>
    </table>

    <table
        align="center" border="0" cellpadding="0" cellspacing="0" class="" style="width:600px;" width="600"
    >
        <tr>
            <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
    <![endif]-->
    <div style="margin:0px auto;max-width:600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
            <tbody>
            <tr>
                <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                    <!--[if mso | IE]>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">

                        <tr>

                            <td
                                class="" style="vertical-align:top;width:600px;"
                            >
                    <![endif]-->
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                         style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                               style="vertical-align:top;" width="100%">
                            <tbody>
                            <tr>
                                <td style="font-size:0px;word-break:break-word;">
                                    <!--[if mso | IE]>

                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td height="1" style="vertical-align:top;height:1px;">

                                    <![endif]-->
                                    <div style="height:1px;">  </div>
                                    <!--[if mso | IE]>

                                    </td></tr></table>

                                    <![endif]-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--[if mso | IE]>
                    </td>

                    </tr>

                    </table>
                    <![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
</div>


</body>
</html>
