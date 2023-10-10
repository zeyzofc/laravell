<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); text-align: left;">
                    <tr>
                        <td style="padding: 20px;">
                            <h1 style="font-size: 24px; color: #333;">Reset Your Password</h1>
                            <p>Hello, {{ $formData['user']->name }}</p>
                            <p>You have requested to change your password. To reset your password, please click the link below:</p>
                            <a href="{{ route('front.resetPassword', $formData['token']) }}" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Reset Password</a>
                            <p>If you didn't request this change, you can ignore this email. Your password will not be changed.</p>
                            <p>Thank you,</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
