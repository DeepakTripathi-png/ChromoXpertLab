$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: base_url + "/admin/referee-doctor/data-table",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'code',
                name: 'code'
            },
            {
                data: 'doctor_name',
                name: 'doctor_name'
            },
            {
                data: 'gender',
                name: 'gender'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            {
                data: 'commission_percent',
                name: 'commission_percent'
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