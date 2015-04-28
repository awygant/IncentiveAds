<?php

function sendEmail($to, $ffid, $barcode, $cta, $userId, $partnerId){

    $sku = $partnerId . "-" . $userId;

    $message = '<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="http://fonts.googleapis.com/css?family=Amaranth:400,400italic" rel="stylesheet" type="text/css">
    <title>Your Fotam Photo and Coupon</title>
    </head>
    <body bgcolor = "#ddd">
        <center>
            <img src = "http://demo.fotam.com/img/logos/fotam-rewards.png" width = "250" alt = "Fotam Rewards"/>


             <p style = "width:566px; font-family: \'Helvetica\', sans-serif">Thanks for participating in the <a href = "http://demo.fotam.com">Fotam Rewards Program!</a> Here is a copy of your photo creation and the coupon you earned.</p>


            <table width = "566" style = "background-color:#eee; border:1px solid #e5e5e5; border-bottom-color: #ccc; border-top-color: #eee; padding:5px; margin:5px; height:250px">
                <tr>
                    <td>
                        <center><h1 style = "font-family: \'Amaranth\', sans-serif; font-style: italic; font-size:26pt; color:#1665c4;">YOUR PHOTO:</h1></center>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style = "background-color:#fff; border: 1px solid #e5e5e5; border-top-color: #fff; border-bottom-color: #ccc; padding:20px; color:#166c54">
                            <tr>
                                <td>
                                    <img src = "http://www.flashfotoapi.com/api/get/' . $ffid . '?width=500&resize=fit" alt = "Your Photo Creation" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width = "566" style = "background-color:#eee; border:1px solid #e5e5e5; border-bottom-color: #ccc; border-top-color: #eee; padding:5px; margin:5px; height:250px">
                <tr>
                    <td>
                        <center><h1 style = "font-family: \'Amaranth\', sans-serif; font-style: italic; font-size:26pt; color:#1665c4;">YOUR COUPON:</h1></center>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style = "background-color:#fff; border: 1px solid #e5e5e5; border-top-color: #fff; border-bottom-color: #ccc; padding:20px; color:#166c54">

                            <tr>
                                <td>
                                    <center><h1 style = "font-family: \'Amaranth\', sans-serif; font-style: italic; font-size:26pt; color:#141211; text-transform:uppercase">' . $cta . '</h1>
                                    <img src = "' . $barcode . '" alt = "Your Coupon" />
                                    <p>' . $sku . '</p>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <p style = "font-family: \'Helvetica\', sans-serif">You received this email because of your participation in the <a href = "http://demo.fotam.com">Fotam Rewards Program.</a></p>
            <p style = "font-family: \'Helvetica\', sans-serif; font-size:10pt">powered by:</p>
            <a href = "http://www.flashfotoinc.com"><img src = "http://demo.fotam.com/img/logos/ff-color.png" width = "100"/></a>
            <p style = "font-family: \'Helvetica\', sans-serif; font-size:10pt"><a href = "http://www.flashfotoinc.com">www.flashfotoinc.com</a></p>
        </center>
    </body>
</html>';


    $subject = "Your Fotam Photo and Coupon!";
    $headers = "From: Fotam Rewards <info@fotam.com>\r\n";
    $headers .= "Reply-To: info@flashfotoinc.com\r\n";
    $headers .= "Return-Path: info@flashfotoinc.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (mail($to, $subject, $message, $headers)) {
        //echo("<p>Message successfully sent!</p>");
    } else {
        //echo("<p>Message delivery failed...</p>");
    }
}

?>


