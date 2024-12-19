<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
</head>
<body>
<style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
                    <!-- Email Body -->
                                <tr>
                                <td class="content-cell" style="font-family: Avenir,Helvetica,sans-serif;
                                    box-sizing: border-box;
                                    color: #333;
                                    font-size: 16px;
                                    line-height: 1.5em;
                                    font-weight:100;
                                    text-align: left;"> 
                                <p style="margin:0 115px"> 
                                    Dear {{ $name }},<br/><br/>
                                    Congratulations on having completed Registration.<br/><br/>
                                    Your registration with the following information<br/><br/>
                                    &emsp;<span style="float:left;width:150px;"> Username </span></span style="float:left;width:10px;">&emsp;:&emsp;&nbsp;</span> {{ $name }} <br/>
                                    &emsp;<span style="float:left;width:150px;"> Email </span></span style="float:left;width:10px;">&emsp;:&emsp;&nbsp;</span> {{ $email }} <br/>
                                    has been well received.<br/><br/>
                                    <br/><br/>
                                    Best Regards,
                                    <br/><br/>
                                    <br/><br/>
                                    </p></td>
                                </tr>
    </table>
</body>
</html>