{% include 'companies/partials/header.volt' %}
    <div class="row">
        <div class="col-lg-12 text-center">
            <div id="images_box" class="clearfix">
                {% if galleries %}
                {% for photo_name in galleries %}
                    <div class="box photo gallery_images">
                        <a href="{{ bucketUrl }}/companies/{{ company_id }}/gallery/{{ photo_name }}" class="fancybox" data-fancybox-group="gallery" title="gallery photo">
                            <img src="{{ bucketUrl }}/companies/{{ company_id }}/gallery/thumb_290x190_{{ photo_name }}" alt="gallery photo"/>
                        </a>
                    </div>
                {% endfor %}
                {% else %}
                <div class="box photo col_images">
                    <a href="/images/supplier_profile1.jpg" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/supplier_profile1.jpg" alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/widgets_photo3.png" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/widgets_photo3.png" alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/supplier_profile2.jpg" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/supplier_profile2.jpg" alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/supplier_profile.jpg" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/supplier_profile.jpg" alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/sweets.png" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/sweets.png" alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/widgets_photo2.png" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/widgets_photo2.png" alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/widgets_photo5.png" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/widgets_photo5.png" alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/fresh_pasta.png" class="fancybox" data-fancybox-group="gallery" title="gallery photo"><img src="/images/fresh_pasta.png"   alt="gallery photo" /></a>
                </div>

                <div class="box photo col_images">
                    <a href="/images/seafood.png" class="fancybox" data-fancybox-group="gallery" title=""><img src="/images/seafood.png" alt="Wonder" /></a>
                </div>
                {% endif %}
            </div> <!-- #/images_box -->
        </div>
    </div>

</div>