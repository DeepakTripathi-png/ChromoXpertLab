$(function () {
    // ------------------------------
    // 📊 Initialize DataTable
    // ------------------------------
    var table = $('#cims_data_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: base_url + "/branch/sample/data-table",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'sample_code', name: 'sample_code' },
            { data: 'appointment_code', name: 'appointment_code' },
            { data: 'patient_name', name: 'patient_name' },
            { data: 'sample_type', name: 'sample_type' },
            { data: 'collection_source', name: 'collection_source' },
            { data: 'destination_lab', name: 'destination_lab' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'collection_datetime', name: 'collection_datetime' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    function reload_table() {
        table.ajax.reload(null, false);
    }

    // ------------------------------
    // 🧩 Add Status Modal dynamically
    // ------------------------------
    if (!$('#statusModal').length) {
        $('body').append(`
            <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-4 border-0">
                        <div class="modal-header" style="background: linear-gradient(135deg,#6267ae,#cc235e); color: #fff;">
                            <h5 class="modal-title fw-bold">Update Sample Status</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form id="statusForm">
                                <input type="hidden" id="sample_id">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Select New Status</label>
                                    <select id="sample_status" class="form-select rounded-pill shadow-sm">
                                        <option value="Pending">Pending</option>
                                        <option value="Collected">Collected</option>
                                        <option value="In Transit">In Transit</option>
                                        <option value="Received">Received</option>
                                        <option value="Processing">Processing</option>
                                        <option value="Analyzed">Analyzed</option>
                                        <option value="Reported">Reported</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Remarks (optional)</label>
                                    <textarea id="remarks" rows="3" class="form-control rounded-3 shadow-sm" placeholder="Add remarks..."></textarea>
                                </div>
                            </form>
                            <div id="statusLogs" class="border-top pt-3 mt-3" style="max-height:200px;overflow-y:auto;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveStatusBtn" class="btn btn-primary rounded-pill">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }

    // ------------------------------
    // 🧠 Handle Status Button Click
    // ------------------------------
    $(document).on('click', '.btn-status', function () {
        var sampleId = $(this).data('id');
        $('#sample_id').val(sampleId);
        $('#sample_status').val('');
        $('#remarks').val('');
        $('#statusLogs').html('<p class="text-muted text-center">Loading logs...</p>');

        // Fetch existing logs
        $.ajax({
            url: base_url + "/branch/sample/" + sampleId + "/logs",
            type: "GET",
            success: function (logs) {
                if (logs.length > 0) {
                    let logHtml = `<ul class="list-group small">`;
                    logs.forEach(log => {
                        logHtml += `
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="fw-semibold">${log.from_status ?? '—'} → ${log.to_status}</span><br>
                                    <small class="text-muted">${log.remarks ?? ''}</small>
                                </div>
                                <small class="text-muted">${new Date(log.changed_at).toLocaleString()}</small>
                            </li>`;
                    });
                    logHtml += `</ul>`;
                    $('#statusLogs').html(logHtml);
                } else {
                    $('#statusLogs').html('<p class="text-muted text-center">No logs found.</p>');
                }
                $('#statusModal').modal('show');
            },
            error: function () {
                $('#statusLogs').html('<p class="text-danger text-center">Error loading logs.</p>');
                $('#statusModal').modal('show');
            }
        });
    });

    // ------------------------------
    // 💾 Save Updated Status (AJAX)
    // ------------------------------
    $('#saveStatusBtn').click(function () {
        var id = $('#sample_id').val();
        var status = $('#sample_status').val();
        var remarks = $('#remarks').val();

        if (!status) {
            alert("Please select a status");
            return;
        }

        $.ajax({
            url: base_url + "/branch/sample/" + id + "/status",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: status,
                remarks: remarks
            },
            beforeSend: function () {
                $('#saveStatusBtn').prop('disabled', true).text('Updating...');
            },
            success: function (response) {
                $('#saveStatusBtn').prop('disabled', false).text('Update');
                if (response.success) {
                    toastr.success(response.message);
                    $('#statusModal').modal('hide');
                    reload_table();
                } else {
                    toastr.warning(response.message);
                }
            },
            error: function (xhr) {
                $('#saveStatusBtn').prop('disabled', false).text('Update');
                toastr.error('Something went wrong! Please try again.');
            }
        });
    });
});
