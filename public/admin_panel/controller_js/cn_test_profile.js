$(document).ready(function () {
    if ($('#cims_data_table').length && !$.fn.DataTable.isDataTable('#cims_data_table')) {
        console.log('Initializing DataTable');
        var table = $('#cims_data_table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: base_url + "/admin/test-profile/data-table",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'code', name: 'code' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'profile_price', name: 'profile_price' },
                { data: 'tests', name: 'tests', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        window.reload_table = function () {
            console.log('Reloading DataTable');
            table.ajax.reload(null, false);
        };
    } else {
        console.log('DataTable already initialized or table not found');
    }
});


