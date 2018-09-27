// default table
var default_table = "";
// report table
var report_table = "";

// preload window
$(document).ready(function ($) {
    var Body = $("body");
    Body.addClass("preloader-site");

    default_table = $(".datatables").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false
    });

    report_table = $(".report_datatables").DataTable({
        dom: "Bfrtip",
        buttons: ["excel"],
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false
    });

    // reportdate
    init_date_onf();

    // menu init
    menu_init();

    // noti
    noti_init();

    //datetime range
    $(".datetimerange").daterangepicker({
        locale: {}
    });
    
});

$(window).load(function () {
    $(".preloader-wrapper").fadeOut();
    $("body").removeClass("preloader-site");
});

// preload ajax
$.LoadingOverlaySetup({
    image: "",
    fontawesome: "fa fa-circle-o-notch fa-spin"
});

function destroy(e, url, id) {
    var txt;
    var r = confirm("Are you sure ?");
    if (r == true) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: url + "/" + id,
            method: "delete",
            beforeSend() {
                $.LoadingOverlay("show");
            },
            success: function (result) {
                var obj = $.parseJSON(result);
                $.LoadingOverlay("hide");
                if (obj.status) {
                    swal("Good job!", obj.description, "success");
                    default_table
                        .row($(e).parents("tr"))
                        .remove()
                        .draw();
                } else {
                    swal("Fail !", obj.description, "error");
                }
            },
            error(xhr, status, error) {
                // alert(error);
            }
        });
    }
}

function init_date_onf() {
    var DATE_ONF = $("#DATE_ONF").val();
    if (DATE_ONF == "ON") {
        $("#datetime").removeAttr("disabled");
    } else {
        $("#datetime").attr("disabled", "disabled");
    }
}

function menu_init() {
    var reply_active = $(".reply a").hasClass("active");
    if (reply_active) {
        $(".reply-main").attr("aria-expanded", "true").removeClass("collapsed").addClass("active");
        $(".reply-sub").addClass("collapse in").attr("aria-expanded", "true").css("height", "auto");
    }

    var report_active = $(".report a").hasClass("active");
    if (report_active) {
        $(".report-main").attr("aria-expanded", "true").removeClass("collapsed").addClass("active");
        $(".report-sub").addClass("collapse in").attr("aria-expanded", "true").css("height", "auto");
    }

}

$(".edit-reply").click(function () {
    var id = $(this).attr("data-id");
    $("#reply_id").val(id);
    $("#nofti-reply textarea").val(
        $("#reply_" + id)
        .html()
        .trim()
    );
    $("#nofti-reply").modal({
        backdrop: "static"
    });
});

function noti_init() {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: window.location.origin + "/api/get-noti",
        method: "GET",
        success: function (result) {
            var str = '';
            for (var i = 0; i < 5; i++) {
                str += '<li><a href="/admin/reply/'+ result[i]['topic_id'] +'" class="notification-item"><span class="dot bg-warning"></span>การแจ้งเตือนใหม่จากคุณ ' + result[i]['user_fullname'] + '</a></li>';
            }
            str += '<li><a href="/admin/reply-recommend" class="more">ดูการแจ้งเตือนทั้งหมด</a></li>';
            $(".notifications").append(str);
            $(".notifications-count").html(result.length);
        },
        error(xhr, status, error) {
            // alert(error);
        }
    });
}