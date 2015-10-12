{{ content() }}
<div class="suggestion_form_box">
    <div class="policy_box_slider">
        <div class="container wallaper">
            <div class="row">
                <div class="col-lg-7 col-lg-offset-1 col-md-7 col-md-offset-1 col-sm-10 col-xs-12">
                    <p class="policy_box_txt">
                        “I cook with wine, sometimes I even add it to the food.”
                        <span>W. C. Fields</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container wallaper policy_box_info">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="red_txt">Make a Suggestion</h1>
                        <p>
                            Your feedback helps us to improve our website and ensure you get the best experience on Find My Rice.
                        </p>

                        <p>
                            Tell us what you think about our website by completing the form below on this page.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                         {{ form.messages('feedback_type') }}
                         {{ form.messages('name') }}
                          {{ form.messages('email') }}
                          {{ form.messages('message') }}
                        <div class="contact_box">
                            <form method="post">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ form.render("feedback_type") }}
                                            <label for="feedback_type" id="label_feedback_type">*</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_name">
                                         {{ form.render("name") }}
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 input_email">
                                        {{ form.render("email") }}
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                         {{ form.render("message") }}
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
                </div>

            </div>
        </div>
    </div>
</div>