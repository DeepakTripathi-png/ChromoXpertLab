$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: base_url + "/admin/sample/data-table",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'sample_code',
                name: 'sample_code'
            },
            {
                data: 'appointment_code',
                name: 'appointment_code'
            },
            {
                data: 'patient_name',
                name: 'patient_name'
            },
            {
                data: 'sample_type',
                name: 'sample_type'
            },
            {
                data: 'collection_source',
                name: 'collection_source'
            },
            {
                data: 'destination_lab',
                name: 'destination_lab'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'collection_datetime',
                name: 'collection_datetime'
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