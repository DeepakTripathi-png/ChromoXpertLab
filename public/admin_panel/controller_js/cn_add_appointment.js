
$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: base_url + "/admin/apointment/test/data-table",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },

            {
                data: 'checkbox',
                name: 'checkbox'
            },
         
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'base_price',
                name: 'base_price'
            },
          
        
        ]
    });

    function reload_table() {
        table.DataTable().ajax.reload(null, false);
    }
});