// default table
var default_table = "";
// report table
var report_table = "";

// preload window
$(document).ready(function($) {
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

  //datetime range
  $(".datetimerange").daterangepicker({
    locale: {}
  });
});

$(window).load(function() {
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
      success: function(result) {
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
        alert(error);
      }
    });
  }
}

function init_date_onf() {
  var DATE_ONF = $("#DATE_ONF").val();
  if (DATE_ONF == "ON") {
    $("#DATETIME").removeAttr("disabled");
  } else {
    $("#DATETIME").attr("disabled", "disabled");
  }
}

$(".edit-reply").click(function() {
  var id = $(this).attr("data-id");
  $("#REPLY_ID").val(id);
  $("#nofti-reply textarea").val(
    $("#reply_" + id)
      .html()
      .trim()
  );
  $("#nofti-reply").modal({ backdrop: "static" });
});
