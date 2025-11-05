
$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: base_url + "/branch/apointment/data-table",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'appointment_code', name: 'appointment_code' },
            { data: 'pet_code', name: 'pet_code' },
            { data: 'pet_name', name: 'pet_name' },
            { data: 'pet_parent_code', name: 'pet_parent_code' },
            { data: 'pet_parent', name: 'pet_parent' },
            { data: 'subtotal', name: 'subtotal' },
            { data: 'discount', name: 'discount' },
            { data: 'total', name: 'total' },
            { data: 'payment_status', name: 'payment_status' },
            { data: 'date', name: 'date' },
            // { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});