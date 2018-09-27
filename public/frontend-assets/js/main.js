/* Set the width of the side navigation to 250px */
function openNav() {
  $("#mySidenav a").hide();
  $("#mySidenav").css("width", "85%");
  setTimeout(function () {
    $("#mySidenav a").show();
  }, 200);
  $("#user-img").fadeOut();
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  $("#mySidenav a").hide();
  $("#mySidenav").css("width", "0px");
  $("#user-img").fadeIn();
}

function init_profile() {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/user-detail",
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      $("#user_fullname").val(result.user_fullname);
      $("#user_email").val(result.user_email);
      $("#user_phone").val(result.user_phone);
      if(result.user_identification != null || result.user_identification != ""){
        $("#user_identification").attr("disabled","disabled");
        $("#user_identification").val(result.user_identification);
      }      
      $.LoadingOverlay("hide");
      $("#update-profile").modal({
        backdrop: "static"
      });
    },
    error(xhr, status, error) {
      alert(error);
    }
  });
}

function init_nofti() {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/user-detail",
    method: "GET",
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      if (result.get_news_update == "Y") {
        $("#nofti").attr("checked", "checked");
      } else {
        $("#nofti").removeAttr("checked");
      }
      $.LoadingOverlay("hide");
      $("#nofti-modal").modal({
        backdrop: "static"
      });
    },
    error(xhr, status, error) {
      alert(error);
    }
  });
}

function update_nofti() {
  var checked = $("#nofti:checked").val();
  var data = {};
  if (checked == 'on') {
    data = {
      'nofti': 'Y'
    };
  } else {
    data = {
      'nofti': 'N'
    };
  }
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: window.location.origin + "/api/user-nofti",
    method: "POST",
    data: data,
    beforeSend() {
      $.LoadingOverlay("show");
    },
    success: function (result) {
      $.LoadingOverlay("hide");

      if (result.status) {
        swal({
          title: result.description,
          icon: "success"
        });
      } else {
        swal({
          title: result.description,
          icon: "error"
        });
      }
      console.log(result);
    },
    error(xhr, status, error) {
      alert(error);
    }
  });

}

function CheckInden() {
  var iden = $(".iden").val().trim();
  if (iden.length != 13) return false;
  for (i = 0, sum = 0; i < 12; i++)
    sum += parseFloat(iden.charAt(i)) * (13 - i);
  if ((11 - sum % 11) % 10 != parseFloat(iden.charAt(12)))
    return false;
  return true;
}

function blank_bg() {
  $("body").css("background-image", "none");
}

function change_bg(){
  $("body").css("background-image", 'url("/frontend-assets/assets/imgs/bg.jpg")');
}