<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Welcome to Mebibrief</title>
</head>

<body>
    <p>Welcome to Mebibrief</p>
    
    <p>
    Hello, <?=$first_name?>.
    You are invited to join on the Mebibrief.
    Here are your login details.
    </p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
        <tbody>
            <tr>
                <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                    &#160;
                </td>
            </tr>
        </tbody>
    </table>
    <p><?= lang('Auth.email') ?>: <?= esc($email) ?></p>
    <p><?= lang('Auth.password') ?>: <?= esc($password) ?></p>
    <p><?= lang('Auth.login') ?> URL: <a href="<?php echo base_url() ?>/accounts/login"><?php echo base_url() ?>/accounts/login</a></p>
</body>

</html>
