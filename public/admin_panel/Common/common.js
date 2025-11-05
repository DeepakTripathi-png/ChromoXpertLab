var base_url = $("#base_url").val();

$(document).ready(() => {
    $(".preview").change(function () {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                console.log(event.target.result);
                $(".preview_image").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});

$(document).on("click", ".change-status", function () {
    var id = $(this).data("id");
    var table = $(this).data("table");
    var flash = $(this).data("flash");
    var actionDiv = $(this);
    if (confirm("Do you really want to change status ?")){
        $.ajax({
            type: "post",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: { id: id, table: table, flash: flash },
            url: base_url + "/admin/change-status",
            beforeSend: function () {
                $(this).hide();
                actionDiv
                    .html(
                        "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                    )
                    .show();
            },
            success: function (data) {
                console.log(data);
                if (data.status == 'true') {
                    var oTable = $("#arm_data_table").dataTable();
                    success_toast("Success", data.message);
                    if (data.user_status == "active") {
                        actionDiv.html(
                            "<i class='fa fa-toggle-on tgle-on' aria-hidden='true' title='Active'></i>"
                        );
                    } else {
                        actionDiv.html(
                            "<i class='fa fa-toggle-off tgle-off' aria-hidden='true' title='In-Active'></i>"
                        );
                    }
                    oTable.fnDraw(false);
                } else {
                    // var oTable = $("#arm_data_table").dataTable();
                    error_toast("error", "Something Went Wrong");
                    // eeror_toast("Error", data.message);
                    // oTable.fnDraw(false);
                }
            },
        });
    }
});

$(document).on("click", ".delete", function () {
    var id = $(this).data("id");
    var table = $(this).data("table");
    var flash = $(this).data("flash");
    var loading = $(this).data("load");
    var actionDiv = $(this);
    var base_url = $("#base_url").val();
    if (confirm("Do you really want to delete this record ?")) {
        $.ajax({
            type: "get",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: { id: id, table: table, flash: flash },
            url: base_url + "/admin/common-delete",
            beforeSend: function () {
                actionDiv
                    .html(
                        "<i class='fa fa-spin fa-spinner' style='color: #000000 !important;'></i>"
                    )
                    .show();
            },
            success: function (data) {
                if(loading == "yes"){
                    window.location.reload();
                } else {
                    var oTable = $("#cims_data_table").dataTable();
                    success_toast("success", data.message);
                    oTable.fnDraw(false);
                }
            },
            error: function (data) {
                error_toast("error", "Something Went Wrong");
            },
        });
    }
});

$(".pass-show").on('click', function() {
    var passwordId = $(this).siblings();
    if (passwordId.attr("type") === "password") {
        passwordId.attr("type", "text");
        $(this).find("i").removeClass("fa-eye")
        $(this).find("i").addClass("fa-eye-slash")
    } else {
        passwordId.attr("type", "password");
        $(this).find("i").addClass("fa-eye")
        $(this).find("i").removeClass("fa-eye-slash")
    }
})

$(document).ready(function() {
    setTimeout(function() {
        $('.backend-error').fadeOut('slow');
    }, 10000);
});

$(document).on("change", "#category_id", function(){
    $.ajax({
        type: "get",
        url: base_url + "/admin/sub-category-list",
        data: { 
            category_id: $(this).val()
        },
        success: function (response) {
            if(response.status == "true"){
                $("#sub_category_id").html(response.options);
            }
        }
    });
})





