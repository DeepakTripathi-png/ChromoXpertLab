

$(function () {
    
    if ($.fn.DataTable.isDataTable('#cims_data_table')) {
        $('#cims_data_table').DataTable().destroy();
    }
    
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: base_url + "/admin/test/data-table",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'test_code',
                name: 'test_code'
            },
         
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'short_name',
                name: 'short_name'
            },
            {
                data: 'department_name',
                name: 'department_name'
            },
            {
                data: 'sample_type',
                name: 'sample_type'
            },
            {
                data: 'base_price',
                name: 'base_price'
            },
            {
                data: 'gst',
                name: 'gst'
            },
            {
                data: 'total_price',
                name: 'total_price'
            },
            {
                data: 'parameters_count',
                name: 'parameters_count'
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
            }
        ]
    });

    function reload_table() {
        table.DataTable().ajax.reload(null, false);
    }
});