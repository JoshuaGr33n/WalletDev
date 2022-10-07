<!DOCTYPE html>
<html>
	<head>
	    <title>Forgot Password</title>
	</head>
	<body>
		<h2>Password reset link</h2>
		<br/>
		<table align="center" border="1" cellpadding="0" cellspacing="0" width="750" style="border-collapse: collapse;">
            <tr>
                <td align="center" bgcolor="#3c8dbc" style="padding: 40px 0 30px 0;">
                	<span style="color:#fff;height: 50px;font-size: 20px;line-height: 50px;text-align: center;width: 230px;"><b>wallet</b></span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;" width="330" align="left" valign="top" bgcolor="#f9f9f9"
                    class="mainbar">
                  <h2 style="text-align: center;">You recently requested to reset your password for your manager account. Use the button below to reset it. The password reset is only valid for the next 24 hours.</h2>
                  <p class="custom-p">Follow this link to reset your password <a style="display: inline-block;margin-bottom: 0;font-weight: 400;text-align: center;vertical-align: middle;touch-action: manipulation;cursor: pointer;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 14px;color: #FFF;background-color: #32c5d2;border-color: #32c5d2;" href="{{ $tokenLink }}" >Reset Password</a></p><br>
                  <br>
                    Thanks,<br>
                    wallet Team<br>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#3c8dbc" style="color:#fff; padding: 15px 0 0px 0;">
                    <p class="custom-p">2019 © wallet</p>
                </td>
            </tr>
        </table>
		<br/>
	</body>
</html>