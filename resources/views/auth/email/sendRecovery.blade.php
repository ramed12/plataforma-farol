<!DOCTYPE html>
            <html lang='PT-BR' xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office'>
            <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width,initial-scale=1'>
              <meta name='x-apple-disable-message-reformatting'>
              <title></title>
            </head>
            <body style='margin:0;padding:0;'>
              <table role='presentation' style='width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#fff;'>
                <tr>
                  <td align='center' style='padding:0;'>
                    <table role='presentation' style='width:702px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;'>
                      <tr>
                        <td style='padding:36px 30px 42px 30px;'>
                          <table role='presentation' style='width:702px;' cellspacing='0' cellpadding='0' border='0'>
                            <tr>
                              <td style='padding:0 0 36px 0;color:#153643;'>
                              <img width='200' src='{!! asset('assets/fundo-auth.png') !!}'><Br><BR>
                                <h1 style='font-size:22px;margin:0 0 20px 0;font-family:Arial,sans-serif;'>Recuperação de senha <b> PLATAFORMA FAROL  </b></h1>
                                <p style='margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;'>Olá <b>{!! $user->name !!}</b>, Tudo bem?</p>
                                <p style='margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;'>Para alterar sua senha, clique <a href='{!! route('auth.recovery.token', $user->token) !!}'>AQUI</a></p>
                                <p style='margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;'>Após clicar no link, você receberá uma nova senha em seu e-mail.</p>
                                <p style='margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;'>Caso não tenha sido você que solicitou essa alteração de senha, não será preciso clicar no link</p>
                                </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style='padding:30px;background:#002e5b;'>
                          <table role='presentation' style='width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;'>
                            <tr>
                              <td style='padding:0;width:50%;' align='left'>
                                <p style='margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;'>
                                  &reg; Equipe Plataforma Farol
                                </p>
                              </td>
                              <td style='padding:0;width:50%;' align='right'>
                                <p style='margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;'>
                                  <a href="https://gaotech.com.br"><img width='90' src="https://gaotech.com.br/site/img/logo.png"></a>
                                </p>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </body>
            </html>
