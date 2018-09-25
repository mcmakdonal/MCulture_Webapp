// preload ajax
$.LoadingOverlaySetup({
    image: "",
    fontawesome: "fa fa-spinner fa-spin"
});

// set pagi
var $pagination = $('#pagination');
var defaultOpts = {
    totalPages: 1
};
$pagination.twbsPagination(defaultOpts);

// preload window
$(document).ready(function ($) {
    $(".use-select2").select2();

    if ($("#province_id").length > 0) {
        // มี ให้เรียกใช้
        province_init();
    }
    if ($(".form_date").length > 0) {
        // มี ให้เรียกใช้
        datetime_init();
    }
    if ($("#organize_id").length > 0) {
        // มี ให้เรียกใช้
        organize_init();
    }

});

//number
$(document).on('keypress', ".number-on", function (event) {
    if (event.which != 8 && isNaN(String.fromCharCode(event.which))) {
        event.preventDefault();
    }
});

// datetime
function datetime_init() {
    $(".form_time").timepicker();

    var startDateTextBox = $('.form_date');
    var endDateTextBox = $('.end_date');

    $.timepicker.dateRange(
        startDateTextBox,
        endDateTextBox, {
            minInterval: (1000 * 60 * 60), // 1hr
            dateFormat: 'dd MM yy',
            start: {}, // start picker options
            end: {} // end picker options					
        }
    );

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
    if ($('#price-table tbody tr').length == 0) {
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
                var select = '';
                if (i == 0) {
                    select = 'selected="selected"';
                }
                str += '<option value="' + result[i]["admission_fee_type_id"] + '" ' + select + ' >';
                str += result[i]["admission_fee_type_name"];
                str += '</option>';
            }
            str += '</select></td>';
            str += '<td><input type="text" class="form-control number-on" name="admission_charge[]" placeholder="ราคา" required></td>';
            str += '<td><button type="button" data="' + uniq + '" onclick="remove_row(this)" class="btn btn-danger">ลบ</button></td>';
            str += '</tr>';
            $("#price-table tbody").append(str);

            $.LoadingOverlay("hide");
        },
        error(xhr, status, error) {
            alert(error);
        }
    });

}

function date_work_init() {
    $("#date-work").modal({
        backdrop: "static"
    });
    if ($('#date-work-table tbody tr').length == 0) {
        add_date_work();
    }
}

function add_date_work() {
    $.LoadingOverlay("show");
    var uniq = Math.random().toString(36).substr(2, 9);
    var str = '';
    var day = ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'];
    str += '<tr id="' + uniq + '">';
    str += '<td><select class="form-control" name="start_date[]" required>';
    for (var i = 0; i < day.length; i++) {
        str += '<option value="' + day[i] + '" >';
        str += day[i];
        str += '</option>';
    }
    str += '</select></td>';
    str += '<td><select class="form-control" name="end_date[]" required>';
    for (var i = 0; i < day.length; i++) {
        str += '<option value="' + day[i] + '" >';
        str += day[i];
        str += '</option>';
    }
    str += '</select></td>';
    str += '<td><input type="text" class="form-control form_time number-on" name="start_time[]" placeholder="" value="08:00" readonly></td>';
    str += '<td><input type="text" class="form-control form_time number-on" name="end_time[]" placeholder="" value="17:00" readonly></td>';
    str += '<td><button type="button" data="' + uniq + '" onclick="remove_row(this)" class="btn btn-danger">ลบ</button></td>';
    str += '</tr>';
    $("#date-work-table tbody").append(str);
    $(".form_time").timepicker();
    $.LoadingOverlay("hide");
}

function remove_row(e) {
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

    $("[name=topic_location]").val(address);
    $("[name=topic_latitude]").val(lat);
    $("[name=topic_longitude]").val(long);

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

    var myArray = [];
    $("#price-table tbody tr select option:selected").each(function () {
        var value = parseInt($(this).val().trim());
        myArray.push(value);
    });

    if (!(myArray.length === new Set(myArray).size)) {
        // duplicate return false | uniq return true
        swal({
            title: "Incorrect",
            text: "ไม่สามารถกำหนดค่า ราคา ให้ซ้ำประเภทได้ กรุณาตรวจสอบอีกครั้ง",
            icon: "warning",
        });
        $("#warning").show();
        $("#price").modal({
            backdrop: "static"
        });
        return false;
    }

});

function pagi_init(totalPages, startPage, function_) {
    if (totalPages == '0') {
        totalPages = 1;
    }
    $pagination.twbsPagination('destroy');
    $pagination.twbsPagination({
        totalPages: totalPages,
        // the current page that show on start
        startPage: (startPage == 0 || startPage == null) ? 1 : startPage,

        // maximum visible pages
        visiblePages: (totalPages > 3) ? 3 : totalPages,

        initiateStartPageClick: false,

        // template for pagination links
        href: false,

        // variable name in href template for page number
        hrefVariable: '{{number}}',

        // Text labels
        first: 'หน้าแรก',
        prev: 'ก่อนหน้า',
        next: 'หน้าต่อไป',
        last: 'หน้าสุดท้าย',

        // carousel-style pagination
        loop: false,

        // callback function
        onPageClick: function (event, page) {
            // console.log(page);
            function_(page)
            $('html,body').animate({
                scrollTop: 0
            }, 'slow');
        },

        // pagination Classes
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled'

    });
}