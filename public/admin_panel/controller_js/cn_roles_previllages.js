$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: base_url + "/admin/roles-privileges/data-table",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'role_name',
            name: 'role_name'
        },
        {
            data: 'privileges',
            name: 'privileges'
        },
        {
            data: 'status',
            name: 'status',
            orderable: false,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
        ]
    });

    function reload_table() {
        table.DataTable().ajax.reload(null, false);
    }
})