$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: base_url + "/branch/pet/data-table",
            type: "GET"
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            { 
                data: 'pet_code', 
                name: 'pet_code' 
            },
            { 
                data: 'pet_parent', 
                name: 'pet_parent' 
            },
            { 
                data: 'name', 
                name: 'name' 
            },
            { 
                data: 'gender', 
                name: 'gender' 
            },
            { 
                data: 'dob', 
                name: 'dob' 
            },
            { 
                data: 'image', 
                name: 'image', 
                orderable: false, 
                searchable: false 
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
        ],
        initComplete: function() {
            // Add custom search input
            $('.dataTables_filter').html('');
        }
    });

    

    // Correct reload function
    function reload_table() {
        table.ajax.reload(null, false);
    }
});


