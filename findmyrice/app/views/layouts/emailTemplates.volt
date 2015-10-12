<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Template</title>
</head>
<body>
<table style="background: #fff; font-family:'CenturyGothic-Regular'; color: #686868; font-size: 16px; width: 100%; margin:0 auto;">
    <tr>
        <td>

            <div style="border-bottom: 2px solid #e53f2e; padding-bottom: 10px;">
                <img src="http://52.10.115.114/images/emailTemplatesImages/logo.png" alt="logo" title="logo" style="width: 100%; max-width: 150px;"/>
            </div>
            {#<p style="text-align: right; margin-top: 20px; color: #686868">Mar 19, 2015  7:35PM  EST</p>#}
            <p style="text-align: right; margin-top: 20px; color: #686868">{{ date('m-d-y', time()) }}</p>
            {{ content() }}
            <div style=" margin-top: 30px; position: relative; height: 240px; background: url('{{ publicUrl }}/images/emailTemplatesImages/heading_bg.png') #efefef no-repeat; background-position: 0 50px;">
                <p style="color: #fff; font-size: 29px; font-family: 'TimeBurner-Regular'; width: 46%; display: inline-block; vertical-align: top; margin-top: 85px; padding-left: 30px;">“The Worlds Best Hospitality
                    Product Directory”</p>
                <div style="width: 50%; float: right;">
                    <img src="{{ publicUrl }}/images/emailTemplatesImages/notebook_img.png" alt="notebook image" style="margin-top: 45px;" />
                </div>
            </div>
            <!--footer-->
            <div style="background: #efefef; border-bottom: 2px solid #e53f2e; font-family: 'Calibri-regular';font-size: 16px;color: #777;">
                <div style="padding: 20px 50px 10px; overflow: hidden;  clear: both">
                    <div style="width: 45%; padding-left: 50px; display: inline-block; float: left;">
                        <span> &copy; Find My Rice. All Rights Reserved</span>
                        <address style="width: 100%; max-width: 320px; font-style: normal; margin-top: 22px; margin-bottom: 30px;">4/13-17 Cook street, Sutherland,
                            Australia 2232</address>
                        <div style="max-width: 370px; width: 100%; padding-left: 0">
                            <span style="display: inline-block; line-height: 35px; margin-left: 0">
                                <a href="http://52.10.115.114/privacy" style="font-family: 'Calibri-regular'; font-size: 16px; color: #777;">Privacy Policy</a>
                            </span>
                            <span style="display: inline-block; line-height: 35px; margin-left: 0">|</span>
                            <span style="display: inline-block; line-height: 35px; margin-left: 0">
                                <a href="http://52.10.115.114/terms"  style="font-family: 'Calibri-regular'; font-size: 16px; color: #777;">Terms and Conditions</a>
                            </span>
                            <br />
                            <span style="display: inline-block; line-height: 35px; margin-left: 0">
                                <a href="#" style="font-family: 'Calibri-regular'; font-size: 16px; color: #777;">Unsubcribe</a></span>
                            <span style="display: inline-block; line-height: 35px; margin-left: 0">|</span>
                            <span style="display: inline-block; line-height: 35px; margin-left: 0">
                                <a href="mailto:info@findymyrice.com" style="font-family: 'Calibri-regular'; font-size: 16px; color: #777;">info@findymyrice.com</a></span>
                        </div>
                    </div>
                    <div style="float: right; display: inline-block; text-align: center; width: 45%;">
                        <div style="margin-top: 65px; padding-left: 0">
                            <span style="display: inline-block; line-height: 35px; margin-left:0">
                                <a href="https://www.facebook.com/findmyrice" style="color: #777;">
                                   <img src="http://52.10.115.114/images/emailTemplatesImages/fb_icon_passive.png" alt="fb icon" />
                                </a>
                            </span>
                            <span style="display: inline-block; line-height: 35px; margin-left:0">
                                <a href="https://www.linkedin.com/company/find-my-rice" style="color: #777;">
                                    <img src="http://52.10.115.114/images/emailTemplatesImages/linkedin_icon_passive.png" alt="linkedin icon" />
                                </a>
                            </span>
                            <span style="display: inline-block; line-height: 35px; margin-left:0">
                                <a href="https://plus.google.com/100800607478397966028/posts" style="color: #777;">
                                  <img src="http://52.10.115.114/images/emailTemplatesImages/g+_icon_passive.png" alt="g+ icon" />
                                </a>
                            </span>
                            <span style="display: inline-block; line-height: 35px; margin-left:0">
                                <a href="https://twitter.com/findmyrice" style="color: #777;">
                                    <img src="http://52.10.115.114/images/emailTemplatesImages/twitter_icon_passive.png" alt="twitter icon" />
                                </a>
                            </span>
                            <span style="display: inline-block; line-height: 35px; margin-left:0">
                                <a href="https://www.pinterest.com/findmyrice/" style="color: #777;">
                                    <img src="http://52.10.115.114/images/emailTemplatesImages/pinterest_icon_passive.png" alt="pinterest icon" />
                                </a>
                            </span>
                        </div>
                        <p><a href="http://52.10.115.114" style="font-family: 'Calibri-regular'; font-size: 16px; color: #777; text-decoration: none">www.findmyrice.com</a></p>
                    </div>
                </div>
            </div>

        </td>
    </tr>
</table>
</body>
</html>