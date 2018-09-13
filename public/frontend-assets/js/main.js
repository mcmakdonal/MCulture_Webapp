/* Set the width of the side navigation to 250px */
function openNav() {
  $("#mySidenav a").hide();
  $("#mySidenav").css("width", "85%");
  setTimeout(function() {
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
    success: function(result) {
      $("#USER_FULLNAME").val(result.user_fullname);
      $("#USER_EMAIL").val(result.user_email);
      $("#USER_PHONENUMBER").val(result.user_phone);
      $.LoadingOverlay("hide");
      $("#update-profile").modal({ backdrop: "static" });
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
    success: function(result) {
      if (result.get_news_update == "Y") {
        $("#nofti").attr("checked", "checked");
      } else {
        $("#nofti").removeAttr("checked");
      }
      $.LoadingOverlay("hide");
      $("#nofti-modal").modal({ backdrop: "static" });
    },
    error(xhr, status, error) {
      alert(error);
    }
  });
}

function update_nofti(){
  var checked = $("#nofti:checked").val();
  var data = {};
  if (checked == 'on') {
    data = {'nofti': 'Y'};
  } else {
    data = {'nofti': 'N'};
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
    success: function(result) {
      $.LoadingOverlay("hide");

      if(result.status){
        swal({
          title: result.description,
          icon: "success"
        });
      }else{
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