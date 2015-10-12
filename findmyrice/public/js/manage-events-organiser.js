(function($) {
    //var oTable = $('#manage-events-organiser').DataTable({
    //    "bProcessing": true,
    //    "columns": [
    //        { "data": "Event Name", "bSortable": true , "width": "40%"},
    //        { "data": "Email", "bSortable": true, "width": "15%" },
    //        { "data": "Phone", "bSortable": true, "width": "10%" },
    //        { "data": "Country", "bSortable": true, "width": "25%" },
    //        { "data": "", "bSortable": false, "width": "5%" }
    //    ]
    //});

    var oTable = $('#manage-events-organiser').dataTable({
        "processing": true,
        "serverSide": true,
        //"sServerMethod" : "POST",
        //"dom": '<lf><t><ip>',
        "ajax": {
            "url": "organisers",
            "type": "POST"
        },
        "columns": [
            {
                "data": "Organiser Name", "orderable": true, "searchable": true, "render": function (data, type, row, meta) {
                return '<input type="checkbox" name="event['+row._id.$id+']">'+row.organiser_name;
                }
            },

            {
                "data": "Email", "orderable": true, "searchable": true, "render": function (data, type, row, meta) {
                return row.email;
                }
            },
            {
                "data": "Phone", "orderable": true, "searchable": false, "render": function (data, type, row, meta) {
                    return row.country_code + row.area_code + row.phone;
                }
            },

            {
                "data": "Country", "orderable": true, "searchable": true, "render": function (data, type, row, meta) {
                    return row.country;
                }
            },

            {
                "data": "", "orderable": false, "searchable": false, "render": function (data, type, row, meta) {
                return '<a href="/manageEvents/editOrganiser/'+ row._id.$id +'">'+
                    '<span title="Edit" class="glyphicon glyphicon-edit glyphicon_red"></span></a>';
                }
            }
        ]
    });
})(jQuery);