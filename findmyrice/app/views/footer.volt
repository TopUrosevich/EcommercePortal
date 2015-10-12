<footer>
    <div class="container wallaper">
        <div class="footer_top">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 footer_widget">
                            <section>
                                <h2 class="title">COMPANY INFO</h2>
                                <ul class="company_info">
                                    <li>{{ link_to("about", "About Us") }}</li>
                                    <li>{{ link_to("press", "Press") }}</li>
                                    <li>{{ link_to("blog", "Blog") }}</li>
                                    <li>{{ link_to("siteMap", "Site Map") }}</li>
                                </ul>
                            </section>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 footer_widget">
                            <section>
                                <h2 class="title">PARTICIPATE</h2>
                                <ul class="company_info">
                                    <li>{{ link_to("lead", "List your Company") }}</li>
                                    <li>{{ link_to("membership", "Pricing") }}</li>
                                    <li>{{ link_to("become-a-contributor", "Become a Contributor") }}</li>
                                </ul>
                            </section>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 footer_widget">
                            <section>
                                <h2 class="title">NEED HELP?</h2>
                                <ul class="company_info">
                                    <li>{{ link_to("help", "Help") }}</li>
                                    <li>{{ link_to("suggestion", "Make a Suggestion") }}</li>
                                    <li>{{ link_to("contact-us", "Contact Us") }}</li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-12 col-sm-6 col-xs-12">
                            <section class="footer_widget sign_up_cont">
                                <h2 class="text-uppercase title">Sign up for our email updates</h2>
                                <p>Stay up to date with our newsletters, whitepapers and special offers from companies.</p>
                                <div class="email_box">
                                    <input type="text" class="email_input" placeholder="Email Address"/>
                                    <button type="submit" class="subscribe">Subscribe</button>
                                </div>
                            </section>
                        </div>
                        <div class="clear"></div>
                        <div class="col-lg-7 col-md-12  col-sm-6">
                            <section class="footer_widget connect_with_us_cont">
                                <h2 class="title text-uppercase">Connect with us</h2>
                                <ul class="social_box">
                                    <li><a href="https://www.facebook.com/findmyrice"><img src="/images/fb_icon.png" alt="fb icon"></a></li>
                                    <li><a href="https://www.linkedin.com/company/find-my-rice"><img src="/images/linkedin_icon.png" alt="linkedin icon"></a></li>
                                    <li><a href="https://plus.google.com/100800607478397966028/posts"><img src="/images/g+_icon.png" alt="g+ icon"></a></li>
                                    <li><a href="https://twitter.com/findmyrice"><img src="/images/twitter_icon.png" alt="twitter icon"></a></li>
                                    <li><a href="https://www.pinterest.com/findmyrice/"><img src="/images/pinterest_icon.png" alt="pinterest icon"></a></li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <p class="copyright">&copy; 2015 Find My Rice. All rights reserved</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <ul class="footer_menu">
                        <li>{{ link_to("terms", "Terms & Conditions") }}</li>
                        <li class="footer_menu_separate">|</li>
                        <li>{{ link_to("privacy", "Privacy Policy") }}</li>
                        <li class="footer_menu_separate">|</li>
                        <li>{{ link_to("refundpolicy", "Refund Policy") }}</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>