$(".active-img").click(function (e) {
    var img_path = $(this).attr("src");

    var img_name = img_path.split("/");
    var img = img_name[img_name.length - 1];
    if (img.includes("-at")) {
        var new_img = img_path.replace("-at", "", img_path);
        $(this).attr("src", new_img);
        $(this).removeClass("active-know");
    } else {
        var inputs = $(".active-img");
        for (var i = 0; i < inputs.length; i++) {
            var src = $(inputs[i]).attr("src");
            var src_img = src.replace("-at", "", src);
            $(inputs[i]).attr("src", src_img);
            $(inputs[i]).removeClass("active-know");
        }

        $(".query_string").val("");

        var new_img = img_path.replace(".png", "-at.png", img_path);
        $(this).attr("src", new_img);
        $(this).addClass("active-know");
        get_knowledge();
    }
});

function get_knowledge(page = 1) {

    var inputs = $(".active-img");
    var know_id = 0;
    for (var i = 0; i < inputs.length; i++) {
        if ($(inputs[i]).hasClass("active-know")) {
            know_id = parseInt($(inputs[i]).attr('data-id'));
        }
    }
    if (know_id == 0) {
        alert("");
        return;
    }

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: window.location.origin + "/knowledges",
        method: "post",
        data: {
            know_id: know_id,
            query_string: $(".query_string").val().trim(),
            page: page
        },
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (result) {
            var startPage = page;
            release_knowledge(know_id, result, startPage);
            $.LoadingOverlay("hide");
        },
        error(xhr, status, error) {
            alert(error);
            $.LoadingOverlay("hide");
        }
    });
}

function release_knowledge(know_id, data, startPage) {
    str = "";
    if (know_id == 1) {
        $.each(data['data_object'], function (i, v) {
            str += '<div class="col-md-6 col-xs-12 col-sm-12" style="margin-top: 10px;">';
            str += '<div class="media no-top rituals" onclick="knowledge_detail_init(this,' + i + ')" style="cursor: pointer;">';
            str += '<div class="media-left">';
            if (v['content_img'] == null || v['content_img'] == "") {
                str += '<img src="' + window.location.origin + "/frontend-assets/assets/imgs/default-img_kl.jpg" + '" class="media-object" style="width:150px">';
            } else {
                str += '<img src="' + v['content_img'] + '" class="media-object" style="width:150px">';
            }
            str += '</div>';
            str += '<div class="media-body">';
            str += '<h4>' + v['content_name'] + '</h4>';
            str += '<p>' + v['type'] + '</p>';
            str += '<textarea class="hidden" id="know_' + i + '">' + JSON.stringify(v) + '</textarea>';
            str += '</div>';
            str += '</div>';
            str += '<hr style="margin-top: 10px;margin-bottom; 10px;" />';
            str += '</div>';
        });
    } else if (know_id == 2) {
        $.each(data['data_object'], function (i, v) {
            var obj = v['data_object'];
            str += '<div class="col-md-6 col-xs-12 col-sm-12" style="margin-top: 10px;">';
            str += '<div class="media no-top tradition" onclick="knowledge_detail_init(this,' + i + ')" style="cursor: pointer;">';
            str += '<div class="media-left">';
            if (obj['article_img'] == null || obj['article_img'] == "") {
                str += '<img src="' + window.location.origin + "/frontend-assets/assets/imgs/default-img_kl.jpg" + '" class="media-object" style="width:150px">';
            } else {
                str += '<img src="' + obj['article_img'] + '" class="media-object" style="width:150px">';
            }
            str += '</div>';
            str += '<div class="media-body">';
            str += '<h4>' + obj['article_name'] + '</h4>';
            str += '<p>' + obj['article_name'] + '</p>';
            str += '<textarea class="hidden" id="know_' + i + '">' + JSON.stringify(v) + '</textarea>';
            str += '</div>';
            str += '</div>';
            str += '<hr style="margin-top: 10px;margin-bottom; 10px;" />';
            str += '</div>';
        });
    } else if (know_id == 3) {
        $.each(data['data_object'], function (i, v) {
            var obj = v['data_object'];
            str += '<div class="col-md-6 col-xs-12 col-sm-12" style="margin-top: 10px;">';
            str += '<div class="media no-top folkart" onclick="knowledge_detail_init(this,' + i + ')" style="cursor: pointer;">';
            str += '<div class="media-left">';
            if (obj['folkart_img'] == null || obj['folkart_img'] == "") {
                str += '<img src="' + window.location.origin + "/frontend-assets/assets/imgs/default-img_kl.jpg" + '" class="media-object" style="width:150px">';
            } else {
                str += '<img src="' + obj['folkart_img'] + '" class="media-object" style="width:150px">';
            }
            str += '</div>';
            str += '<div class="media-body">';
            str += '<h4>' + obj['folkart_name'] + '</h4>';
            str += '<p>' + obj['folkart_name'] + '</p>';
            str += '<textarea class="hidden" id="know_' + i + '">' + JSON.stringify(v) + '</textarea>';
            str += '</div>';
            str += '</div>';
            str += '<hr style="margin-top: 10px;margin-bottom; 10px;" />';
            str += '</div>';
        });
    } else if (know_id == 4) {
        $.each(data['data_object'], function (i, v) {
            var obj = v['data_object'];
            str += '<div class="col-md-6 col-xs-12 col-sm-12" style="margin-top: 10px;">';
            str += '<div class="media no-top thailitdir" onclick="knowledge_detail_init(this,' + i + ')" style="cursor: pointer;">';
            str += '<div class="media-left">';
            str += '<img src="' + window.location.origin + "/frontend-assets/assets/imgs/default-img_kl.jpg" + '" class="media-object" style="width:150px">';
            str += '</div>';
            str += '<div class="media-body">';
            str += '<h4>' + obj['title_main'] + '</h4>';
            str += '<p>' + obj['title_main'] + '</p>';
            str += '<textarea class="hidden" id="know_' + i + '">' + JSON.stringify(v) + '</textarea>';
            str += '</div>';
            str += '</div>';
            str += '<hr style="margin-top: 10px;margin-bottom; 10px;" />';
            str += '</div>';
        });
    }

    var totalPages = data['total'];
    pagi_init(totalPages, startPage, get_knowledge);
    $("#knowledge-body .row").html(str);
    $("#knowledge-pagi span.totalPages").html("จำนวนหน้าทั้งหมด : " + totalPages);
}

function get_hilight(page = 1) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: window.location.origin + "/hilight",
        method: "post",
        data: {
            page: page,
            query_string: $(".query_string").val().trim(),
        },
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (obj) {
            var startPage = page;
            var totalPages = obj['total'];
            var str = '';
            $.each(obj['data_object'], function (i, v) {
                str += '<div class="col-md-6 col-xs-12 col-sm-12" style="margin-top: 10px;">';
                str += '<div class="media no-top" onclick="hilight_detail_init(this,' + i + ')" style="cursor: pointer;">';
                str += '<div class="media-left">';
                str += '<img src="' + window.location.origin + "/frontend-assets/assets/imgs/default-img_hl.jpg" + '" class="media-object" style="width:150px">';
                str += '</div>';
                str += '<div class="media-body">';
                str += '<h4>' + v['activity_name'] + '</h4>';
                str += '<p>' + v['activity_name'] + '</p>';
                str += '</div>';
                str += '</div>';
                str += '<div style="padding: 5px;font-size: 17px;">';
                str += '<p> <i class="fa fa-clock-o" aria-hidden="true"></i>  ' + timetthai(v['start_date']) + '</p>';
                str += '<p> <i class="fa fa-map-marker" aria-hidden="true"></i> ' + v['location'] + ' </p>';
                str += '<textarea class="hidden" id="hilight_' + i + '">' + JSON.stringify(v) + '</textarea>';
                str += '</div>';
                str += '<hr style="margin-top: 10px;margin-bottom; 10px;" />';
                str += '</div>';
            });
            pagi_init(totalPages, startPage, get_hilight);
            $("#hilight-body .row").html(str);
            $("#hilight-pagi span.totalPages").html("จำนวนหน้าทั้งหมด : " + totalPages);
            $.LoadingOverlay("hide");
        },
        error(xhr, status, error) {
            alert(error);
            $.LoadingOverlay("hide");
        }
    });
}

function knowledge_detail_init(e, id) {
    $.LoadingOverlay("show");
    var blank = window.location.origin + "/frontend-assets/assets/imgs/default-img_kl.jpg";
    // console.log(obj);
    if ($(e).hasClass("rituals")) {
        var obj = JSON.parse($("#know_" + id).val());

        var image = (obj['content_img'] == null || obj['content_img'] == "") ? blank : obj['content_img'];

        $("div.knowledge-banner img").attr("src", image);
        $(".knowledge-img h3").html(obj['content_name']);
        $(".knowledge-img h4").html(obj['keyword']);
        $(".knowledge-img span").html(obj['type']);

        $(".knowledge-global a").attr("href", obj['content_url']);

        $("ul.knowledge-list").html("");
        var rituals_month = (obj['rituals_month'] == null || obj['rituals_month'] == "") ? " " : obj['rituals_month'];
        var rituals_time = (obj['rituals_time'] == null || obj['rituals_time'] == "") ? " " : obj['rituals_time'];
        $("ul.knowledge-list").append('<li> <i class="fa fa-clock-o" aria-hidden="true"></i> ' + rituals_month + ' ' + rituals_time + ' </li> ');
        var location = (obj['location'] == null || obj['location'] == "") ? " " : obj['location'];
        $("ul.knowledge-list").append('<li> <i class="fa fa-map-marker" aria-hidden="true"></i> ' + location + ' </li> ');
        $("ul.knowledge-list").append('<li> <i class="fa fa-info" aria-hidden="true"></i> โทรศัพท์ </li> ');
        var user = (obj['author'] == null || obj['author'] == "") ? "-" : obj['author'];
        $("ul.knowledge-list").append('<li> <i class="fa fa-user" aria-hidden="true"></i> ' + user + '  </li> ');

    } else if ($(e).hasClass("tradition")) {
        var data = JSON.parse($("#know_" + id).val());
        var obj = data['data_object'];
        var image = (obj['article_img'] == null || obj['article_img'] == "") ? blank : obj['article_img'];

        $("div.knowledge-banner img").attr("src", image);
        $(".knowledge-img h3").html(obj['article_name']);
        $(".knowledge-img h4").html(obj['article_name']);
        $(".knowledge-img span").html(obj['about']);

        $(".knowledge-global a").attr("href", data['content_url']);

        $(".knowledge-body").html("");
        $(".knowledge-body").html(obj['history']);

        $("ul.knowledge-list").html("");
        $("ul.knowledge-list").append('<li> <i class="fa fa-clock-o" aria-hidden="true"></i> ' + obj['event_date'] + ' </li> ');
        $("ul.knowledge-list").append('<li> <i class="fa fa-map-marker" aria-hidden="true"></i> ' + obj['location'] + ' </li> ');
        $("ul.knowledge-list").append('<li> <i class="fa fa-info" aria-hidden="true"></i> โทรศัพท์ </li> ');

    } else if ($(e).hasClass("folkart")) {
        var data = JSON.parse($("#know_" + id).val());
        var obj = data['data_object'];
        var image = (obj['folkart_img'] == null || obj['folkart_img'] == "") ? blank : obj['folkart_img'];

        $("div.knowledge-banner img").attr("src", image);
        $(".knowledge-img h3").html(obj['folkart_name']);
        $(".knowledge-img h4").html(obj['folkart_name']);
        $(".knowledge-img span").html(obj['about']);

        $(".knowledge-global a").attr("href", data['content_url']);

        $(".knowledge-body").html("");
        $(".knowledge-body").html(obj['history']);

        $("ul.knowledge-list").html("");
        $("ul.knowledge-list").append('<li> <i class="fa fa-clock-o" aria-hidden="true"></i>  </li> ');
        $("ul.knowledge-list").append('<li> <i class="fa fa-map-marker" aria-hidden="true"></i> ' + obj['location'] + ' </li> ');
        $("ul.knowledge-list").append('<li> <i class="fa fa-info" aria-hidden="true"></i> โทรศัพท์ </li> ');
    } else if ($(e).hasClass("thailitdir")) {
        var data = JSON.parse($("#know_" + id).val());
        var obj = data['data_object'];
        var image = blank;

        $("div.knowledge-banner img").attr("src", image);
        $(".knowledge-img h3").html(obj['title_main']);
        $(".knowledge-img h4").html(obj['composer']);
        $(".knowledge-img span").html(obj['composition']);

        $(".knowledge-global a").attr("href", data['content_url']);

        $(".knowledge-body").html("");
        $(".knowledge-body").html(obj['story']);

        $("ul.knowledge-list").html("");
        $("ul.knowledge-list").append('<li> <i class="fa fa-clock-o" aria-hidden="true"></i>  </li> ');
        $("ul.knowledge-list").append('<li> <i class="fa fa-map-marker" aria-hidden="true"></i> </li> ');
        $("ul.knowledge-list").append('<li> <i class="fa fa-info" aria-hidden="true"></i> โทรศัพท์ </li> ');
        var user = (obj['author'] == null || obj['author'] == "") ? "-" : obj['author'];
        $("ul.knowledge-list").append('<li> <i class="fa fa-user" aria-hidden="true"></i> ' + user + '  </li> ');
    }


    $.LoadingOverlay("hide");
    $("#knowledge-modal").modal({
        backdrop: "static"
    });
}

function hilight_detail_init(e, id) {
    $.LoadingOverlay("show");
    var obj = JSON.parse($("#hilight_" + id).val());

    var image = window.location.origin + "/frontend-assets/assets/imgs/default-img_hl.jpg";

    $("div.knowledge-banner img").attr("src", image);
    $(".knowledge-img h3").html(obj['activity_name']);
    $(".knowledge-img h4").html(obj['activity_name']);
    $(".knowledge-img span").html(obj['organization']);

    $(".knowledge-global a").attr("href", obj['content_url']);

    $(".knowledge-body").html("");
    $(".knowledge-body").html(obj['description']);

    $("ul.knowledge-list").html("");
    $("ul.knowledge-list").append('<li> <i class="fa fa-clock-o" aria-hidden="true"></i> ' + timetthai(obj['start_date']) + ' - ' + timetthai(obj['end_date']) + ' </li> ');
    $("ul.knowledge-list").append('<li> <i class="fa fa-map-marker" aria-hidden="true"></i> ' + obj['location'] + ' </li> ');
    $("ul.knowledge-list").append('<li> <i class="fa fa-info" aria-hidden="true"></i> โทรศัพท์ </li> ');
    var user = (obj['accessory'] == null || obj['accessory'] == "") ? "-" : obj['accessory'];
    $("ul.knowledge-list").append('<li> <i class="fa fa-user" aria-hidden="true"></i> ' + user + '  </li> ');
    $.LoadingOverlay("hide");
    $("#hilight-modal").modal({
        backdrop: "static"
    });
}

function blank_bg() {
    $("body").css("background-image", "none");
}