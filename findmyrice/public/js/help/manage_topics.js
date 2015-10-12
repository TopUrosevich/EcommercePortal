(function($) {
    var oTable = $('#manage-topics').DataTable({
        //"bProcessing": true,
        "columns": [
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
        ],
        "order": [[ 3, "asc" ]]
    });
})(jQuery);