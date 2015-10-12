{{ content() }}
<div class="contactus_slider">
    <div class="container wallaper">
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-1">

            </div>
            <div class="col-lg-5 col-md-8 col-sm-8 col-xs-9 info_contactus_slider">
                <p>“The only real stumbling block is fear of failure. In cooking you've got to have a what-the-hell attitude.”
                    ― Julia Child</p>
            </div>
        </div>
    </div>
</div>
<div class="contactus_box_outer">
    <div class="container wallaper">
        <div class="row">
            <div class="col-lg-1 col-md-1">

            </div>
            <div class="col-lg-7 col-md-7 col-sm-8 contactus_box">
                <h2>Contact Us</h2>
                <p>
                    We are here to answer any questions you may have about your experience on Find My Rice. Reach out to us and we’ll respond as son as we can.
                </p>
                <p>
                    Even if there is something you have always wanted to experience and can’t find it on Find My Rice, let us know and we promoise we’ll do our best to find it for you.
                </p>
                    {{ form.messages('name') }}
                    {{ form.messages('email') }}
                    {{ form.messages('message') }}
                <div class="contact_box">
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 input_name">
                                {{ form.render("name") }}
                                {#<input type="text" id="name" name="name" required="required" />#}
                                <label for="name">Name</label>
                            </div>
                            <div class="col-lg-6 col-md-6 input_email">
                                {{ form.render("email") }}
                                {#<input type="text" id="email" name="email" required="required" />#}
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {{ form.render("message") }}
                                {#<textarea id="message" name="message" required="required" ></textarea>#}
                                <label for="message">Message</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-right send_btn_box">
                                <button type="submit" class="send_btn">send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 "></div>
            <div class="col-lg-3 col-md-3 col-sm-4 contact_us_info">
                <h3>email</h3>
                <p>info@findmyrice.com</p>
                <h3>telephone</h3>
                <span>+61 2 9098 5095</p>
                    <h3>Address</h3>
                <p>4/13-17 Cook street</p>
                <p> Sutherland</p>
                <p>  NSW</span><span>  Australia</span>
                    <p>  2232</p>
            </div>
        </div>
    </div>
</div>