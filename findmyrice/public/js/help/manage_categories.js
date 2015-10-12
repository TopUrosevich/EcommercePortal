(function($) {
    var oTable = $('#manage-categories').DataTable({
        //"bProcessing": true,
        "columns": [
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true}
        ],
        "order": [[ 1, "asc" ]]
    });
})(jQuery);