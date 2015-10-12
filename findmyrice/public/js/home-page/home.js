(function($) {

    // Custom autocomplete instance.
    $.widget( "app.autocomplete", $.ui.autocomplete, {

        // Which class get's applied to matched text in the menu items.
        options: {
            highlightClass: "ui-state-highlight"
        },

        _renderItem: function( ul, item ) {

            // Replace the matched text with a custom span. This
            // span uses the class found in the "highlightClass" option.
            var re = new RegExp( "(" + this.term + ")", "gi" ),
                cls = this.options.highlightClass,
                template = "<span class='" + cls + "'>$1</span>",
                label = item.label.replace( re, template ),
                $li = $( "<li/>" ).appendTo( ul );

            // Create and return the custom menu item content.
            $( "<a/>" )
                .html( label )
                .appendTo( $li );

            return $li;

        }
    });

    var cache1 = {};
    $( "#name_pcck" ).autocomplete({
        minLength: 2,
        source: function( request, response ) {
            var term = request.term;
            if ( term in cache1 ) {
                response( cache1[ term ] );
                return;
            }
            $.post("/ajax/getName_pcck", request, function(data, textStatus) {
                //data contains the JSON object
                //textStatus contains the status: success, error, etc
                cache1[ term ] = data;
                response( data );
            }, "json");
        }
    });


    var cache2 = {};
    $( "#location" ).autocomplete({
        minLength: 2,
        source: function( request, response ) {
            var term = request.term;
            if ( term in cache2 ) {
                response( cache2[ term ] );
                return;
            }
            $.post("/ajax/getLocationData", request, function(data, textStatus) {
                //data contains the JSON object
                //textStatus contains the status: success, error, etc
                cache2[ term ] = data;
                response( data );
            }, "json");
        }
    });
    /*var img_array = [1, 2, 3, 4],
        newIndex = 0,
        index = 0,
        interval = 5000;
    (function changeBg() {
        $('.slider_box').css('backgroundImage', function () {
            return 'url(images/HomePage' + img_array[index] +'.jpg)';
        });
        index = (index + 1) % img_array.length;
        setTimeout(changeBg, interval);
    })();*/
})(jQuery);