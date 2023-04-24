jQuery(document).ready(function($) {

    var jobtable = $('#table').DataTable({

        ajax: {
            url: datatablesajax.url + '?action=get_posts_for_datatables'
        },


        columns: [
            { data: 'id',visible: false, searchable: false,
                render: function (data, type, row) {
                    return data;
                },
            },
            { data: 'date' },
            { data: 'number' },
            { data: 'phone' },
            { data: 'company' },
            { data: 'instrument_type',
                render: function (data, type, row, meta) {
                    if (type === "display") {
                        data = '<div>'+
                            '<form method="post" action="">' +
                            '<input type="hidden" name="id" value="'+ row.id + '">'+
                            '<input type="submit" value="'+ row.instrument_type + '">' + '</form> </div>';
                    }
                    return data;
                }
            },
            { data: 'complaint' },
            { data: 'repeat_number',
                render: function (data, type,row) {
                    if (type === "display") {
                        if (data !== '') {
                            data = '<div>' +
                                '<form method="post" action="">' +
                                '<input type="hidden" name="title" value="' + row.repeat_number + '">' +
                                '<input type="submit" value="' + row.repeat_number + '">' + '</form> </div>';
                        }
                    }
                        return data;
                    }

            },
            { data: 'agreement',
                render: function ( data, type, row, meta ){
                    if (data == 'on'){
                        return '<span style="color:' + 'green' + '">Узгоджено</span>';
                    }
                    else if (data == ""){
                        return '<span style="color:' + 'red' + '">Зателефонуйте</span>';
                    }
                },

            },
            { data: 'ready',
                render: function ( data, type, row, meta ){
                    if (data == 'on'){
                        return '<span style="color:' + 'green' + '">Виконано</span>';
                    }
                    else if (data == ""){
                        return '<span style="color:' + 'red' + '">У роботі</span>';
                    }
                },
            },
            { data: 'given',
                render: function ( data, type, row, meta ){
                    if (data == 'on'){
                        return '<span style="color:' + 'green' + '">Видано</span>';
                    }
                    else if (data == ""){
                        return '<span style="color:' + 'red' + '">Не видано</span>';
                    }
                },
            },
        ],
        columnDefs: [
            {
                "render": function (data, type, row) {
                    return '<a href="' + data + '"></a>';
                },
                "targets": 0
            }
        ]
    });
});