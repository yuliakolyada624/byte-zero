<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
      /* Reboot for outlook.com */
      .ExternalClass {
        width: 100%;
      }

      .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {
        line-height: inherit;
      }
      /* Reboot for outlook.com end */

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      html,
      body {
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 20px;
        color: #304659;
        background: #ffffff;
      }

      body{
        font-family: "Poppins", sans-serif;
        padding: 68px 30px 40px 30px;
      }

      table {
        border-collapse: collapse;
        border-spacing: 0;
      }

      tr, td, th {
        max-width: 100%;
        width: 100%;
      }

      h2 {
        margin: 0px;
        font-family: 'Poppins', sans-serif;
        font-style: normal;
        font-weight: 500;
        font-size: 20px;
        line-height: 20px;
        text-align: center;
        color: #304659;
      }

      p{
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        line-height: 20px;
        color: #304659;
        font-weight: 400;
        text-align: center;
      }

      a{
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        line-height: 20px;
        color: #148BDF;
        font-weight: 500;
        text-align: center;
        transition: .3s;
        text-decoration: none;
        margin: 0 auto;
        word-break: break-all;
        outline: none;
        border: none;
      }

      a:hover{
        text-decoration: underline;
      }

      .logo{
        display: block;
        max-width: 190px; 
        margin: 0px auto 0 auto;
        width: 100%;
      }

      .btn-primary{
        width: 100%;
        font-size: 14px;
        line-height: 24px;
        font-weight: 600;
        background: #148BDF;
        border-radius: 8px;
        display: block;
        padding: 10px;
        color: #fff;
        border: 1px solid #148BDF;
      }


      .btn-primary:hover{
        text-decoration: none;
        background: transparent;
        color: #148BDF;
      }

      div{
       
      }

      @media screen and (max-width: 1024px) {
        body{
          font-family: "Poppins", sans-serif;
          padding: 40px 15px 40px 15px;
        }
      }
      @media screen and (max-width: 576px) {
        div{
          padding: 18px 15px 24px 15px;
          margin: 0px auto 40px auto;
        }
      }

    </style>
    <title>Med-Test | Reset password</title>
  </head>
  <body>
  <div style="background-color: #ffffff; 
        max-width: 566px; 
        width: 100%;
        margin: 0px auto 68px auto;
        padding: 18px 40px 36px 40px;
        border: 1px solid #D4DCE4;
        border-radius: 16px;">
     <table cellspacing="0" border="0" style="width: 100%; border-collapse: collapse; border-spacing: 0; border: 0 none; padding: 0px;">
        <tbody>
          <tr>
            <td style="padding: 0px 0px 16px 0px; border-bottom: 1px solid #D4DCE4;">
              <a href="" class="logo" title="Link to webpage">
                <img src="<?= base_url() ?>assets/themes/default/img/content/emails/logo-email.png" alt="logo" style="width: 100%;">
              </a>
            </td>
          </tr>
          <tr>
            <td style="padding: 32px 0px 18px 0px;">
              <h2>Forgot Your Password?</h2>
            </td>
          </tr>
          <tr>
            <td style="padding: 0px 0px 60px 0px;">
              <p>We received a request to reset the password for your account. To reset your password, click on the button below.</p>
            </td>
          </tr>
          <tr>
            <td style="padding: 0px 0px 30px 0px;">
              <a class="btn-primary" href="<?= url_to('set-new-password') ?>?token=<?= $token ?>">Reset Password</a>
            </td>
          </tr>
          <tr>
            <td style="padding: 0px 0px 68px 0px;">
              <p>
                <a href="<?= url_to('set-new-password') ?>?token=<?= $token ?>"><?= url_to('set-new-password') ?>?token=<?= $token ?></a>
              </p>
            </td>
          </tr>
          <tr>
            <td style="padding: 0px 0px 20px 0px; border-bottom: 1px solid #D4DCE4;">
              <p>If the button above is disabled, try to copy and paste the link displayed into your browser. If you persist to have problems, contact our support team at <a href="mailto:support@med-test.ai" style="font-weight: 400;">support@med-test.ai</a></p>
            </td>
          </tr>
          <tr>
            <td style="padding: 20px 0px 0px 0px;">
              <p>If this request was a mistake, Please ignore this email to avoid unwated account changes.</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <table cellspacing="0" border="0" style=" width: 100%; border-collapse: collapse; margin: 0px auto 0px auto; border-spacing: 0; border: 0 none; padding: 0px;">
      <tbody>
        <tr>
          <td>
            <p style="font-size: 13px;">© <?=date("Y")?> Med-Test. All rights reserved.</p>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
