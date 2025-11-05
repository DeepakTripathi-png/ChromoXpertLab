$(function () {
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: true,  // Enable searching for custom inputs
        ajax: base_url + "/admin/departments/data-table",
        dom: 'lrtip',  // 'l'ength, 'r'table, 't'ools (processing), 'i'nfo, 'p'agination – hides default search box
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'code', name: 'code' },
            { data: 'department_name', name: 'department_name' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', orderable: false, searchable: true },  // Enable searchable for status column
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10,  // Default rows per page (adjust as needed)
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],  // Add length change dropdown if needed
        order: [[2, 'asc']]  // Default sort by department_name
    });

    // Custom global search (like reference: keyup event)
    $('#searchInput').on('keyup', function () {
        table.search(this.value).draw();  // Sends to backend as search[value]
    });

    // Custom status filter (like reference: change event, filters on status column)
    $('#statusFilter').on('change', function () {
        table.column(4).search(this.value).draw();  // Sends to backend as columns[4][search][value]
    });

    // Optional: Clear filters button (uncomment and add to HTML if desired)
    // $('#clearFilters').on('click', function () {
    //     $('#searchInput').val('').trigger('keyup');
    //     $('#statusFilter').val('').trigger('change');
    // });
});