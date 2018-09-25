// preload ajax
$.LoadingOverlaySetup({
  image: "",
  fontawesome: "fa fa-spinner fa-spin"
});

// preload window
$(document).ready(function ($) {
  $(".use-select2").select2();
});

//number
$(".number-on").keypress(function (event) {
  // console.log(event.which);
  if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
    event.preventDefault();
  }
});

//inform
function change_inform() {
  var IFTYPE_ID = $("#IFTYPE_ID").val();
  var html = "";
  if (IFTYPE_ID == 1) {
    html = $("#form-1").clone();
    $("#form-replace").html(html);
    datetime_init();
    province_init();
  } else if (IFTYPE_ID == 2) {
    html = $("#form-2").clone();
    $("#form-replace").html(html);
    datetime_init();
    province_init();
  } else {
    html = $("#form-3").clone();
    $("#form-replace").html(html);
  }
}

//complaintform
function change_complaintform() {
  var CPTYPE_ID = $("#CPTYPE_ID").val();
  var html = "";
  if (CPTYPE_ID == 1) {
    html = $("#form-1").clone();
    $("#form-replace").html(html);
    datetime_init();
    province_init();
  } else if (CPTYPE_ID == 2) {
    html = $("#form-2").clone();
    $("#form-replace").html(html);
  } else if (CPTYPE_ID == 3) {
    html = $("#form-3").clone();
    $("#form-replace").html(html);
  } else {
    html = $("#form-4").clone();
    $("#form-replace").html(html);
  }
}

// datetime
function datetime_init() {
  $(".form_date").datetimepicker({
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0,
    format: "dd MM yyyy",
    pickerPosition: "bottom-left"
  });
  $(".form_time").datetimepicker({
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0,
    format: "hh:ii",
    pickerPosition: "bottom-left"
  });
}

function province_init() {
  $("#PROVINCE_ID option").remove();
  clear_addr();
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/province",
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      $("#PROVINCE_ID").append(
        $("<option>", {
          value: "",
          text: "กรุณาเลือกจังหวัด"
        })
      );

      for (var i = 0; i < result.length; i++) {
        $("#PROVINCE_ID").append(
          $("<option>", {
            value: result[i]["province_id"],
            text: result[i]["province_name"]
          })
        );
      }
      $.LoadingOverlay("hide");
    },
    error(xhr, status, error) {
      alert(error);
    }
  });
}

function search_district(e) {
  var PROVINCE_ID = $(e).val();
  if (PROVINCE_ID == "") {
    return clear_addr();
  }

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/district/" + PROVINCE_ID,
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      clear_addr();
      for (var i = 0; i < result.length; i++) {
        $("#DISTRICT_ID").append(
          $("<option>", {
            value: result[i]["district_id"],
            text: result[i]["district_name"]
          })
        );
      }
      $.LoadingOverlay("hide");
    },
    error(xhr, status, error) {
      alert(error);
    }
  });
}

function search_subdistrict(e) {
  var DISTRICT_ID = $(e).val();
  $("#SUB_DISTRICT_ID option").remove();
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/subdistrict/" + DISTRICT_ID,
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      for (var i = 0; i < result.length; i++) {
        $("#SUB_DISTRICT_ID").append(
          $("<option>", {
            value: result[i]["subdistrict_id"],
            text: result[i]["subdistrict_name"]
          })
        );
      }
      $.LoadingOverlay("hide");
    },
    error(xhr, status, error) {
      alert(error);
    }
  });
}

function clear_addr() {
  $("#DISTRICT_ID option").remove();
  $("#SUB_DISTRICT_ID option").remove();
  $("#DISTRICT_ID").append(
    $("<option>", {
      value: "",
      text: "กรุณาเลือกอำเภอ"
    })
  );
  $("#SUB_DISTRICT_ID").append(
    $("<option>", {
      value: "",
      text: "กรุณาเลือกตำบล"
    })
  );
  $.LoadingOverlay("hide");
  return false;
}

function select2_init_addr() {
  $("#PROVINCE_ID").select2();
  $("#DISTRICT_ID").select2();
  $("#SUB_DISTRICT_ID").select2();
}

function map_init() {
  $("#map-modal").modal({
    backdrop: "static"
  });
  initAutocomplete();
  // google.maps.event.trigger(map, 'resize');
}

function select_map() {
  var lat = $("#lat").val();
  var long = $("#long").val();
  var address = $("#address").val();

  $("[name$=_LOCATION]").val(address);
  $("[name$=_LATITUDE]").val(lat);
  $("[name$=LONGITUDE]").val(long);

  $("#map-modal").modal("hide");
}

function map_close() {
  $("#map-modal").modal({
    backdrop: "static"
  });
}

// check comment user login
$(".comment-form-check").click(function (e) {
  var CMDATA_NAME = $("form #CMDATA_NAME").val();
  var CMDATA_DETAILS = $("form #CMDATA_DETAILS").val();
  var CMDATA_PERSONNAME = $("form #CMDATA_PERSONNAME").val();
  if (CMDATA_NAME == "" || CMDATA_DETAILS == "" || CMDATA_PERSONNAME == "") {
    swal("กรุณากรอกข้อมูลให้ครบ");
    return false;
  }

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/check-auth",
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      $.LoadingOverlay("hide");
      if (result.status) {
        return $("#form-form").submit();
      } else {
        $("#register").modal({
          backdrop: "static"
        });
        return false;
      }
    }
  });
});

// check inform user login
$(".inform-form-check").click(function (e) {
  var IFTYPE_ID = $("#IFTYPE_ID").val();
  var IFDATA_NAME = $("form #IFDATA_NAME").val();
  var IFDATA_DETAILS = $("form #IFDATA_DETAILS").val();
  var PROVINCE_ID = $("form #PROVINCE_ID").val();
  var DISTRICT_ID = $("form #DISTRICT_ID").val();
  var SUB_DISTRICT_ID = $("form #SUB_DISTRICT_ID").val();
  if (IFTYPE_ID == 1) {
    if (IFDATA_NAME == "" || IFDATA_DETAILS == "") {
      swal("กรุณากรอกข้อมูลให้ครบ");
      return false;
    }
  } else if (IFTYPE_ID == 2) {
    if (
      IFDATA_NAME == "" ||
      IFDATA_DETAILS == "" ||
      PROVINCE_ID == "" ||
      DISTRICT_ID == "" ||
      SUB_DISTRICT_ID == ""
    ) {
      swal("กรุณากรอกข้อมูลให้ครบ");
      return false;
    }
  } else {
    if (IFDATA_NAME == "" || IFDATA_DETAILS == "") {
      swal("กรุณากรอกข้อมูลให้ครบ");
      return false;
    }
  }

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/check-auth",
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      $.LoadingOverlay("hide");
      if (result.status) {
        return $("#form-form").submit();
      } else {
        $("#register").modal({
          backdrop: "static"
        });
        return false;
      }
    }
  });
});

// check complaint user login
$(".complaint-form-check").click(function (e) {
  var CPTYPE_ID = $("#CPTYPE_ID").val();
  var CPDATA_NAME = $("form #CPDATA_NAME").val();
  var CPDATA_STORENAME = $("form #CPDATA_STORENAME").val();
  var CPDATA_DETAILS = $("form #CPDATA_DETAILS").val();
  var PROVINCE_ID = $("form #PROVINCE_ID").val();
  var DISTRICT_ID = $("form #DISTRICT_ID").val();
  var SUB_DISTRICT_ID = $("form #SUB_DISTRICT_ID").val();
  if (CPTYPE_ID == 1) {
    if (
      CPDATA_NAME == "" ||
      CPDATA_DETAILS == "" ||
      CPDATA_STORENAME == "" ||
      PROVINCE_ID == "" ||
      DISTRICT_ID == "" ||
      SUB_DISTRICT_ID == ""
    ) {
      swal("กรุณากรอกข้อมูลให้ครบ");
      return false;
    }
  } else if (CPTYPE_ID == 2) {
    if (CPDATA_NAME == "" || CPDATA_DETAILS == "") {
      swal("กรุณากรอกข้อมูลให้ครบ");
      return false;
    }
  } else if (CPTYPE_ID == 3) {
    if (CPDATA_NAME == "" || CPDATA_DETAILS == "") {
      swal("กรุณากรอกข้อมูลให้ครบ");
      return false;
    }
  } else {
    if (CPDATA_NAME == "" || CPDATA_DETAILS == "") {
      swal("กรุณากรอกข้อมูลให้ครบ");
      return false;
    }
  }

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/check-auth",
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      $.LoadingOverlay("hide");
      if (result.status) {
        return $("#form-form").submit();
      } else {
        $("#register").modal({
          backdrop: "static"
        });
        return false;
      }
    }
  });
});

// prev
$(".prevpage").click(function (e) {
  var cpage = parseInt(
    $(".cpage")
    .html()
    .trim()
  );
  var cur_page = cpage - 1;

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/list-news",
    method: "POST",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    data: {
      page: cur_page
    },
    success: function (result) {
      $("#block-list").html(" ");
      for (var i = 0; i < result["data_object"].length; i++) {
        var data = JSON.stringify(result["data_object"][i]);
        var str =
          '<a href="#" class="list-group-item" onclick="opn_news(' +
          i +
          ')"><i class="fa fa-bullhorn" aria-hidden="true"></i> ' +
          result["data_object"][i]["activity_name"] +
          " </a>";
        str +=
          '<textarea class="hidden" id="txt' + i + '">' + data + "</textarea>";
        $("#block-list").append(str);
      }
      $.LoadingOverlay("hide");
      // console.log(cur_page);
      if (cur_page == 1) {
        $(".prevpage").attr("disabled", "disabled");
      }
      $(".nextpage").removeAttr("disabled");
      $(".cpage").html(cur_page);
    }
  });
});

// next
$(".nextpage").click(function (e) {
  var cpage = parseInt(
    $(".cpage")
    .html()
    .trim()
  );
  var mpage = parseInt(
    $(".mpage")
    .html()
    .trim()
  );
  var cur_page = cpage + 1;

  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/list-news",
    method: "POST",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    data: {
      page: cur_page
    },
    success: function (result) {
      $("#block-list").html(" ");
      for (var i = 0; i < result["data_object"].length; i++) {
        var data = JSON.stringify(result["data_object"][i]);
        var str =
          '<a href="#" class="list-group-item" onclick="opn_news(' +
          i +
          ')"><i class="fa fa-bullhorn" aria-hidden="true"></i> ' +
          result["data_object"][i]["activity_name"] +
          " </a>";
        str +=
          '<textarea class="hidden" id="txt' + i + '">' + data + "</textarea>";
        $("#block-list").append(str);
      }
      $.LoadingOverlay("hide");
      // console.log(cur_page);
      if (cur_page == mpage) {
        $(".nextpage").attr("disabled", "disabled");
      }
      $(".prevpage").removeAttr("disabled");
      $(".cpage").html(cur_page);
    }
  });
});

function opn_news(id) {
  var data = $("#txt" + id).val();
  var obj = JSON.parse(data);
  // console.log(obj);
  $("#activity_name").html(obj.activity_name);
  $("#description").html(
    "รายละเอียด : " + (obj.description == null ? "" : obj.description)
  );
  $("#start_date").html(
    "วันที่เริ่ม : " + (obj.start_date == null ? "" : timetthai(obj.start_date))
  );
  $("#end_date").html(
    "วันที่สิ้นสุด : " + (obj.end_date == null ? "" : timetthai(obj.end_date))
  );
  $("#start_time").html(
    "เปิดเวลา : " + (obj.start_time == null ? "" : obj.start_time)
  );
  $("#end_time").html(
    "ปิดเวลา : " + (obj.end_time == null ? "" : obj.end_time)
  );
  $("#location").html(
    "สถานที่ : " + (obj.location == null ? "" : obj.location)
  );
  $("#accessory").html(
    "ผู้เขียน : " + (obj.accessory == null ? "" : obj.accessory)
  );
  $("#organization").html(
    "หน่วยงาน : " + (obj.organization == null ? "" : obj.organization)
  );
  $("#content_url").attr("href", obj.content_url);

  $("#modal-news").modal();
}

function timetthai(day) {
  var monthNamesThai = [
    "มกราคม",
    "กุมภาพันธ์",
    "มีนาคม",
    "เมษายน",
    "พฤษภาคม",
    "มิถุนายน",
    "กรกฎาคม",
    "สิงหาคม",
    "กันยายน",
    "ตุลาคม",
    "พฤษจิกายน",
    "ธันวาคม"
  ];

  var sub = day.split('-');
  var y = parseInt(sub[0]) + 543;
  var m = parseInt(sub[1]);
  var d = parseInt(sub[2]);
  return " วันที่ " + d + " " + monthNamesThai[m] + " " + y;
}


function recommend_init() {
  $("#topic_sub_type_id option").remove();
  clear_addr();
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/sub-type",
    method: "GET",
    data: {
      main_type: $("#topic_main_type_id").val()
    },
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      for (var i = 0; i < result.length; i++) {
        $("#topic_sub_type_id").append(
          $("<option>", {
            value: result[i]["topic_sub_type_id"],
            text: result[i]["topic_sub_type_name"]
          })
        );
      }
      $.LoadingOverlay("hide");
    },
    error(xhr, status, error) {
      alert(error);
    }
  });
}