(function($) {
    //var oTable = $('#manage-events').DataTable({
    //    "bProcessing": true,
    //    "columns": [
    //        { "data": "Name", "bSortable": true , "width": "40%"},
    //        { "data": "Category", "bSortable": true, "width": "15%" },
    //        { "data": "Approval", "bSortable": false, "width": "5%" },
    //        { "data": "Date", "bSortable": true, "width": "25%" },
    //        { "data": "", "bSortable": false, "width": "10%" }
    //    ]
    //});


   var oTable = $('#manage-events').dataTable({
        "processing": true,
        "serverSide": true,
        //"sServerMethod" : "POST",
        //"dom": '<lf><t><ip>',
        "ajax": {
            "url": "manageevents/index",
            "type": "POST"
        },
        "columns": [
            {
                "data": "Name", "orderable": true, "searchable": true, "render": function (data, type, row, meta) {
                    return '<input type="checkbox" name="event['+row._id.$id+']">'+row.event_name;
                }
            },

            {
                "data": "Category", "orderable": true, "searchable": true, "render": function (data, type, row, meta) {
                    return row.category.title;
                }
            },
            {
                "data": "Approval", "orderable": false, "searchable": false, "render": function (data, type, row, meta) {
                    if(row.approval){
                        return '<input type="checkbox" checked />';
                    } else {
                        return '<input type="checkbox" />';
                    }
                }
            },

            {
                "data": "Date", "orderable": true, "searchable": true, "render": function (data, type, row, meta) {

                    var start_date_date = new Date(row.start_date * 1000);
                    var start_date_day = start_date_date.getUTCDate();
                    var start_date_year = start_date_date.getUTCFullYear();
                    var start_date_month= start_date_date.getUTCMonth() + 1;

                    var end_date_date = new Date(row.end_date * 1000);
                    var end_date_day = end_date_date.getUTCDate();
                    var end_date_year = end_date_date.getUTCFullYear();
                    var end_date_month= end_date_date.getUTCMonth() + 1;

                    return start_date_day+'/'+start_date_month+'/'+start_date_year +'-'+end_date_day+'/'+end_date_month+'/'+end_date_year ;
                }
            },

            {
                "data": "", "orderable": false, "searchable": false, "render": function (data, type, row, meta) {
                return '<a href="/manageEvents/edit/'+ row._id.$id +'">'+
                        '<span title="Edit" class="glyphicon glyphicon-edit glyphicon_red"></span></a>'+
                        '<a href="/events/'+ row.category.alias +'/'+ row._id.$id + '">'+
                        '<span title="View" class="glyphicon glyphicon-eye-open glyphicon_red"></span></a>'+
                        '<a href="/manageEvents/organiserMessages/'+row._id.$id +'">'+
                        '<span title="View" class="glyphicon glyphicon-envelope glyphicon_red"></span></a>';
                }
            }
        ]
    });
})(jQuery);