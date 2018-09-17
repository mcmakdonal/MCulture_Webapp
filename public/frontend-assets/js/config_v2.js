// preload ajax
$.LoadingOverlaySetup({
    image: "",
    fontawesome: "fa fa-spinner fa-spin"
});

// preload window
$(document).ready(function ($) {
    $(".use-select2").select2();
    province_init();
    datetime_init();
    organize_init();
});

//number
$(".number-on").keypress(function (event) {
    // console.log(event.which);
    if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
        event.preventDefault();
    }
});

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

function organize_init() {
    $("#organize_id option").remove();
    clear_addr();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: window.location.origin + "/api/get-organizations",
        method: "GET",
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (result) {
            for (var i = 0; i < result.length; i++) {
                $("#organize_id").append(
                    $("<option>", {
                        value: result[i]["organize_id"],
                        text: result[i]["organize_name"]
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

function province_init() {
    $("#province_id option").remove();
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
            $("#province_id").append(
                $("<option>", {
                    value: "",
                    text: "กรุณาเลือกจังหวัด"
                })
            );

            for (var i = 0; i < result.length; i++) {
                $("#province_id").append(
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
    var province_id = $(e).val();
    if (province_id == "") {
        return clear_addr();
    }

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: window.location.origin + "/api/district/" + province_id,
        method: "GET",
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (result) {
            clear_addr();
            for (var i = 0; i < result.length; i++) {
                $("#district_id").append(
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
    var district_id = $(e).val();
    $("#sub_district_id option").remove();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: window.location.origin + "/api/subdistrict/" + district_id,
        method: "GET",
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (result) {
            for (var i = 0; i < result.length; i++) {
                $("#sub_district_id").append(
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
    $("#district_id option").remove();
    $("#sub_district_id option").remove();
    $("#district_id").append(
        $("<option>", {
            value: "",
            text: "กรุณาเลือกอำเภอ"
        })
    );
    $("#sub_district_id").append(
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

function price_init() {
    $("#price").modal({
        backdrop: "static"
    });
    if ($('.table tbody tr').length == 0) {
        add_price_row();
    }
}

function add_price_row() {
    var uniq = Math.random().toString(36).substr(2, 9);
    var str = '';
    str += '<tr id="' + uniq + '"><td>';
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: window.location.origin + "/api/get-admissionfees",
        method: "GET",
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (result) {
            str += '<select class="form-control" name="admission_fee_type_id[]" required>';
            for (var i = 0; i < result.length; i++) {

                str += '<option value="' + result[i]["admission_fee_type_id"] + '">';
                str += result[i]["admission_fee_type_name"];
                str += '</option>';
            }
            str += '</select></td>';
            str += '<td><input type="text" class="form-control" name="admission_charge[]" placeholder="ราคา" required></td>';
            str += '<td><button type="button" data="' + uniq + '" onclick="remove_row_price(this)" class="btn btn-danger">ลบ</button></td>';
            str += '</tr>';
            $("#price-table tbody").append(str);

            $.LoadingOverlay("hide");
        },
        error(xhr, status, error) {
            alert(error);
        }
    });

}

function remove_row_price(e) {
    var id = $(e).attr('data');
    $("#" + id + "").remove();
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
$(".form-check").click(function (e) {
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

// ดัก event เวลา modal ถูกเปิด บังคับให้กรอกข้อมูล
$('#register').on('show.bs.modal', function () {
    $("#register input").attr("required", "required");
});

// ดัก event เวลา modal price ไม่กำหนดค่า ราคามา
$('#price').on('hidden.bs.modal', function () {
    $("#price-table tbody tr input[type=text]").each(function () {
        var value = $(this).val().trim();
        var id = $(this).closest('tr').attr('id');
        if (value === "") {
            $("#" + id).remove();
        }
    });
});