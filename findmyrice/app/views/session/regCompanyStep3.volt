{{ form('id': 'form-register-keywords') }}
{{ content() }}

<div class="register_box wallaper container">
    <div class="row step_box">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <h2 class="company_txt">Key Words</h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 text-right step_box">
            <ul class="step_block">
                <li>Step</li>
                <li><a href="#" class="active">3</a></li>
                <li>of</li>
                <li><a href="#">3</a></li>
                <li>{{ link_to('session/register-company-step2','Back','class':"back_btn" ,'id':"back_btn_3" ) }}</li>
            </ul>
        </div>
    </div>
    <div class="row info_keywords">
        <div class="col-lg-offset-1 col-lg-8">
            <p>
                Add key words that best describe your products or services. These will help users find the products or services
                they are looking for. Once registered you will also be able to upload your product lists.
            </p>
            <p>
                You can add multiple key words at the same time by separating them with a comma e. g. Fresh pasta, nodles,
                fresh sauces, frozen sauces, etc. Alternatively you can look up common key words.
            </p>
            <div class="row">
                <div class="col-lg-6 cl-md-6 col-sm-6 col-xs-6">
                    {{ form.render('key_words') }}
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 add_btn_box">
                    <button type="button" class="red_btn" id="add_keywords">Add</button>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 or_txt">
                    <span>OR</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 look_up_btn_box">
                    <button type="button" data-toggle="modal" data-target="#lookUpKeyWordsModal" class="red_btn" id="look-up-key-words">Look Up Key Words</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ form.render('key_words_area') }}
                </div>
            </div>
            <div class="register_btn_box">{{ form.render('Register') }}</div>
            <div id="please_wait" style="display: none;">Please wait...</div>

        </div>
    </div>
</div>
</form>

<div class="modal fade" id="lookUpKeyWordsModal" tabindex="-1" role="dialog"
     aria-labelledby="attendModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                        <div class="modal-title">
                            <div class="keywords_separate">
                                <p class="red_txt">Browse the categories to find common key words to describe your products & services</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 keywords_popup_box">

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body_keywords">
                                <select name="lookUpKeyWords" id="lookUpKeyWords" multiple>
                                    <option value="Bakery">Bakery</option>
                                    <option value="Beverage - Non-alcoholic">Beverage - Non-alcoholic</option>
                                    <option value="Butcher">Butcher</option>
                                    <option value="Cleaning Supplies">Cleaning Supplies</option>
                                    <option value="Coffee & Tea">Coffee & Tea</option>
                                    <option value="Dairy">Dairy</option>
                                    <option value="Dietary">Dietary</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Foodservice">Foodservice</option>
                                    <option value="Grocery">Grocery</option>
                                    <option value="Packaging">Packaging</option>
                                    <option value="Produce">Produce</option>
                                    <option value="Seafood">Seafood</option>
                                    <option value="Smallgoods">Smallgoods</option>
                                    <option value="Technology">Technology</option>
                                </select>
                            </div>
                        </div>

                        <div class="row modal-footer">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body_keywords text-right">
                                <button type="button" class="red_btn mb15" id="lookUpAddKeyWords">Add Key Words</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>