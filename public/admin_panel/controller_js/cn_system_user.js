$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        
        ajax: base_url + "/admin/system-user/data-table",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'user_name',
            name: 'user_name'
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'role',
            name: 'role'
        },
        {
            data: 'mobile_no',
            name: 'mobile_no'
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
        }]
    });

    function reload_table() {
        table.DataTable().ajax.reload(null, false);
    }
})
