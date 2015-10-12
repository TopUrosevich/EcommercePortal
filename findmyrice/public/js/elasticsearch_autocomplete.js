(function($) {

    // Custom autocomplete instance.
    $.widget( "app.autocomplete", $.ui.autocomplete, {

        // Which class get's applied to matched text in the menu items.
        options: {
            highlightClass: "ui-state-highlight",
            category_item_highlightClass: "select-item-highlight"
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
        //highlightClass: "bold-text",
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
        },
        select: function(event, ui) {
            $(event.target).val(ui.item.value);
            var selected_val = ui.item.value;
            var search_field = '';
            if(selected_val.indexOf("Searches the word") > -1){
                var in_all =  selected_val.split("(Searches the word");
                search_field = in_all[0].trim() + " in All";
                $(event.target).val(search_field);
            }
            //$('#simple_search_form').submit();
            return false;
        }
    });

    var cache2 = {};
    $( "#location" ).autocomplete({
        //highlightClass: "bold-text",
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
        },
        select: function(event, ui) {
            $(event.target).val(ui.item.value);
            //$('#search').submit();
            return false;
        }
    });

    var cache3 = {};
    $( "#product_or_service" ).autocomplete({
        //highlightClass: "bold-text",
        minLength: 2,
        source: function( request, response ) {
            var term = request.term;
            if ( term in cache3 ) {
                response( cache3[ term ] );
                return;
            }
            $.post("/ajax/getProductsNameAdvancedSearch", request, function(data, textStatus) {
                //data contains the JSON object
                //textStatus contains the status: success, error, etc
                cache3[ term ] = data;
                response( data );
            }, "json");
        },
        select: function(event, ui) {
            $(event.target).val(ui.item.value);
            //$('#search').submit();
            return false;
        }
    });

})(jQuery);