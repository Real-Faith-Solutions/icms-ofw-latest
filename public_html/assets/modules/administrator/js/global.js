function getUnreadNotification() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getUnreadNotification",
    },
    function (rs) {
      var list = "";
      if (parseInt(rs.data.count) >= 1) {
        $("#notif-icon").removeClass("pr-2");
        $("#notif-badge-count").removeClass("hide");
        var notifCount = parseInt(rs.data.count);
        if (notifCount > 99) {
          $("#notif-badge-count").html("99+");
        } else {
          $("#notif-badge-count").html(notifCount);
        }

        $.each(rs.data.list, function (key, val) {
          list +=
            '<li class="tagged-case li-notif-list" dataid="' +
            val.notification_id +
            '">';
          list += '   <div class="row">';
          list += '       <div class="col-8 notif-content">';
          list +=
            '           <small class="">' +
            val.notification_message +
            "</small>";
          list += "       </div>";
          list += '       <div class="col-4">';
          try {
            list +=
              '           <p class="notif-time">' +
              jQuery.timeago(val.notification_date_added) +
              "</p>";
          } catch (e) {}
          list += "       </div>";
          list += "   </div>";
          list += "</li><hr>";
        });

        $(".div-mark-all").removeClass("hide");
        $(".unread-count-note").removeClass("hide");
        $(".unread-count-note").text(
          "You have " + notifCount + " unread notification()"
        );
      } else {
        $("#notif-badge-count").html("0");
        $("#notif-badge-count").addClass("hide");
        $("#notif-icon").addClass("pr-2");
        list += '<li class="tagged-case">';
        list += '   <div class="row">';
        list += '       <div class="col-12 notif-content">';
        list +=
          "             <center><h5>No active notification found!<h5></center>";
        list += "       </div>";
        list += "   </div>";
        list += "</li>";

        $(".div-mark-all").addClass("hide");
        $(".unread-count-note").addClass("hide");
      }

      $("#ul-notif-list").html(list);

      setTimeout(function () {
        getUnreadNotification();
      }, 100000);
    },
    "json"
  );
}

function getIssueStatus() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getIssueStatus",
    },
    function (rs) {
      var l = "<option selected value='' >Select Issue Status</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.parameter_count_id +
          "' data-name='" +
          val.parameter_name +
          "'>" +
          val.parameter_name +
          "</option>";
      });
      $(".sel-issue-status").html(l);
    },
    "json"
  );
}

$(document).ready(function () {
  // remove auto complete of date picker
  $(".datepicker").attr("autocomplete", "off");
  $(".datetimepicker").attr("autocomplete", "off");

  //    if (document.readyState === 'complete') {
  var keyword = "";
  findInDataDictionary(keyword);
  findInDirectory(keyword);
  //    }

  //header menu active
  $(".nav-menu-item li a").click(function () {
    $("li a").removeClass("active");
    $(this).addClass("active");
  });

  $(".sidebar-dtry").mouseleave(function () {
    $(".x-directory").click();
  });

  $(".sidebar-data-dnry").mouseleave(function () {
    $(".x-data-dnry").click();
  });

  $(".btn-show-directory").click(function () {
    $(".card-directory-wrapper").toggleClass();
  });

  $("#txt-directory-search").on("search", function () {
    var keyword = $(this).val();
    findInDirectory(keyword);
  });

  $("#txt-data-dic-search").on("search", function () {
    var keyword = $(this).val();
    findInDataDictionary(keyword);
  });

  $("#msgmodal").delegate(".btn-prompt_yes", "click", function () {
    var func = $(this).attr("data-function");
    executeFunctionByName(func, window);
  });

  $("#msgmodal").delegate(".btn-prompt_no", "click", function () {
    var func = $(this).attr("data-function");
    executeFunctionByName(func, window);
  });

  $("#modal_session").click(function () {
    window.location.href = "user_login";
  });

  // Add class c-out
  $(document).mouseup(function (e) {
    if ($(e.target).closest(".c-out").length === 0) {
      $(".c-out").hide();
    } else {
      $(".c-out").hide();
    }

    if ($(e.target).closest(".action-menu").length === 0) {
      $(".action-menu").hide();
    }
  });

  $(".btn-close-floater , #overlay-in").on("click", function () {
    if ($("#sidebar").hasClass("sidebar_")) {
      $("#sidebar").removeClass("sidebar_");
      $("#overlay-in").removeClass("overlay-open");
      $("#menu").removeClass("shadow-menu_top");
      $(".btn-close-directory").hide();
      $("#txt-directory-search").val("");
      findInDirectory();
    } else if ($("#sidebar-dictionary").hasClass("sidebar_")) {
      $("#sidebar-dictionary").removeClass("sidebar_");
      $("#dictionary").removeClass("shadow-menu");
      $("#sidebar-dictionary").removeClass("dictionary_style");
      $("#overlay-in").removeClass("overlay-open");
      $("#menu").removeClass("menu-dictionary");
      $("#icon-dictionary").show();
      $(".btn-close-dictionary").hide();
      $(".btn-close-directory").hide();
      $("#txt-data-dic-search").val("");
      findInDataDictionary();
    }
  });

  //    $('#icon,#icon-dictionary').tooltip({boundary: 'window'})

  $("#floater-directory ").on("click", function () {
    $("#overlay-in").addClass("overlay-open");
    $(".btn-close-directory").show();
    $("#sidebar").addClass("sidebar_");
    $("#menu").addClass("shadow-menu_top");
  });
  $("#floater-dictionary").on("click", function () {
    $("#sidebar-dictionary").addClass("sidebar_");
    $("#dictionary").addClass("shadow-menu");
    $("#sidebar-dictionary").addClass("dictionary_style");
    $("#overlay-in").addClass("overlay-open");
    $("#menu").addClass("menu-dictionary");
  });

  $("#icon-dictionary").on("click", function () {
    $(".btn-close-dictionary").show();
  });
  $(".dictionary_description").on("click", function () {});

  $("#list-dictionary").delegate(
    ".dictionary_description",
    "click",
    function () {
      $(this).css("white-space", "normal");
    }
  );

  //check strong password
  $("input:password").on("keyup", function (e) {
    var password = $(this).val();
    var elem_id = $(this).attr("id");
    var check_strength = $(this).attr("check_strength");
    $("#" + elem_id + "-error-password-validate").show();
    if (check_strength) {
      if (check_strength == "true") {
        let msg = checkPasswordStrength(password);
        let check = $(this).attr("data-error-password-validate");
        $(this).attr("check_strength_is_valid", msg == "validated" ? "1" : "0");
        if (check == "1") {
          $("#" + elem_id + "-error-password-validate").html(
            msg == "validated" ? "" : msg
          );
        } else {
          $(this).attr("data-error-password-validate", "1");
          $("#" + elem_id)
            .parent()
            .append(
              '<span id="' +
                elem_id +
                '-error-password-validate" style="color: #d6795b;font-size: 0.8rem;">' +
                (msg == "validated" ? "" : msg) +
                "</span>"
            );
        }
      }
    }
  });
});

function checkPasswordStrength(password) {
  let msg = "";
  let regex = "";
  let message = "";

  // console.log(password);
  // if(!(password.length >= 8)) {
  //     message = 'least 8 character';
  //     msg += (msg == '')? message :',' + message;
  // }

  regex = /^(?=.*[a-z]).+$/; // Lowercase character pattern
  if (!regex.test(password)) {
    message = "lowercase letter";
    msg += msg == "" ? message : "," + message;
  }

  regex = /^(?=.*[A-Z]).+$/; // Uppercase character pattern
  if (!regex.test(password)) {
    message = "uppercase letter";
    msg += msg == "" ? message : "," + message;
  }

  regex = /^(?=.*[0-9]).+$/; // Number check
  if (!regex.test(password)) {
    message = "number";
    msg += msg == "" ? message : "," + message;
  }

  regex = /^(?=.*[_\W]).+$/; // Special character
  if (!regex.test(password)) {
    message = "special character";
    msg += msg == "" ? message : "," + message;
  }

  if (msg !== "") {
    return "Password must contain at least one " + msg;
  }

  return "validated";
}

function findInDataDictionary(keyword = "") {
  $.post(
    sAjaxGlobalData,
    {
      type: "findInDataDictionary",
      keyword: keyword,
    },
    function (rs) {
      var l = "";
      $.each(rs.data.details, function (key, val) {
        l += '     <li class=""  >';
        l += '                           <div class="card mt-0">';
        l += '                                <div class="row">';
        l +=
          '                                    <div class="col-lg-12 col-md-12 col-sm-12  align-items-center ">';
        l +=
          '                                        <div class="D_agency_details"> ';
        l +=
          '                                            <span class=" dictionary_title " style="font-size: 18px;"> ' +
          val.dictionary_name +
          " </span>";
        l +=
          '                                            <br> <p class="dictionary_description pt-2"  data-id=" ' +
          val.dictionary_name +
          '">' +
          val.dictionary_description +
          " </p>";
        l += "                                       </div>";
        l += "                                   </div>";
        l += "                               </div>";
        l += "                           </div>";
        l += "                        </li>";
      });
      $("#list-dictionary").html(l);
      $("#list-dictionary").next().hide();
      if (l == "") {
        $(".directory-container .nd-header").hide();
        $("#list-dictionary").next().show();
        $(".directory-container .nd-body-content").html(
          "SORRY, WE COULDN'T FIND ANY DIRECTORY RELATED TO" +
            '<span class="font-italic"> "' +
            keyword +
            '"</span>.'
        );
      }
    },
    "json"
  );
}

function findInDirectory(keyword = "") {
  $.post(
    sAjaxGlobalData,
    {
      type: "findInDirectory",
      keyword: keyword,
    },
    function (rs) {
      var l = "";
      $.each(rs.data.list, function (key, val) {
        if (val.branches.length) {
          $.each(val.branches, function (k, v) {
            l += '        <li class=""  >';
            l += '                            <div class="card">';
            l += '                               <div class="row">';
            l +=
              '                                    <div class="col-lg-12 col-md-12 col-sm-12  align-items-center ">';
            l +=
              '                                        <div class="D_agency_details"> ';
            l +=
              '                                           <span class=" agency_title "> ' +
              val.agency_name +
              " - " +
              v.agency_branch_name +
              "  </span><br>";
            if (v.address[0] !== "") {
              l +=
                '                                        <span class="text-normal">  ' +
                v.address.brgy +
                " " +
                v.address.city +
                " " +
                v.address.province +
                " " +
                v.address.city +
                "</span><br> ";
            }
            l +=
              '                                                  <span style="color: #e88f14;"><i class="fas fa-address-card"> Contact Details</i></span><br> ';

            l += '<div style="margin-left:13px;">';

            if (v.contact_details_primary[0] !== "") {
              var name =
                v.contact_details_primary.agency_contact_firstname +
                " " +
                v.contact_details_primary.agency_contact_middle_name +
                " " +
                v.contact_details_primary.agency_contact_lastname;
              l +=
                '                                            <span class="txt-light"><i class="fas fa-user-tag blue__"></i> &nbsp;' +
                name +
                " </span><br>";
            }
            l +=
              '                                             <span class="txt-light"><i class="fas fa-envelope-open-text blue__"></i> &nbsp;' +
              v.agency_branch_email +
              "</span> <br>";
            if (v.agency_branch_mobile_number != "undefined") {
              l +=
                '                                            <span class="txt-light"><i class="fas fa-mobile-alt blue__"></i> &nbsp;' +
                v.agency_branch_mobile_number +
                " </span><br>";
            }
            if (v.agency_branch_telephone_number != "undefined") {
              l +=
                '                                            <span class="txt-light"><i class="fas fa-phone-alt blue__"></i> &nbsp;' +
                v.agency_branch_telephone_number +
                " </span><br>";
            }

            l += "";
            l += "                                            </div>";
            l += "                                    </div>";
            l += "                               </div>";
            l += "                           </div>";
            l += "                        </li>";
          });
        }
      });
      $("#list-directory").html(l);
      $("#list-directory").next().hide();

      if (l == "") {
        $(".directory-container .nd-header").hide();
        $("#list-directory").next().show();
        $(".directory-container .nd-body-content").html(
          "SORRY, WE COULDN'T FIND ANY DIRECTORY RELATED TO" +
            '<span class="font-italic"> "' +
            keyword +
            '"</span>.'
        );
      }
    },
    "json"
  );
}

function session_relogIn() {
  setTimeout(function () {
    window.location.href = "user_login";
  }, 3000);
}

function b64EncodeUnicode(str) {
  return btoa(
    encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function (match, p1) {
      return String.fromCharCode(parseInt(p1, 16));
    })
  );
}

function b64DecodeUnicode(str) {
  return decodeURIComponent(
    Array.prototype.map
      .call(atob(str), function (c) {
        return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
      })
      .join("")
  );
}

function _setStorageData(data, storageName) {
  var enc = b64EncodeUnicode(JSON.stringify(data));
  localStorage.setItem(storageName, enc);
  return enc;
}

function _getStorageData(storageName) {
  var data = localStorage.getItem(storageName);

  if (data === null) {
    return false;
  } else {
    var dec = b64DecodeUnicode(data);
    return JSON.parse(dec);
  }
}

function _rmStorageDataById(array, element) {
  const index = array.indexOf(element);

  if (index !== -1) {
    array.splice(index, 1);
  }
}

function icmsModalClose() {
  $("#msgmodal").modal("hide");
}

function icmsModal(param) {
  if (typeof param.title !== "undefined") {
    $(".h5-title").html(param.title);
  } else {
    $(".h5-title").html("");
  }

  if (typeof param.body !== "undefined") {
    $(".m-body").html("<div >" + param.body + "</div>");
  } else {
    $(".m-body").html('<div class="text-center"></div>');
  }

  if (typeof param.btn_yes_function !== "undefined") {
    var yes_func = param.btn_yes_function;
  } else {
    var yes_func = "";
  }

  if (typeof param.btn_no_function !== "undefined") {
    var no_func = param.btn_no_function;
  } else {
    var no_func = "";
  }

  if (typeof param.footer_button !== "undefined") {
    if (param.footer_button === true) {
      if (typeof param.prompt !== "undefined") {
        $(".m-footer").html(
          '<button type="button" class="btn btn-secondary-grey btn-save-done btn-prompt_no" data-function="' +
            no_func +
            '">No</button><button type="button" class="btn btn-primary btn-prompt_yes" data-function="' +
            yes_func +
            '" >Yes</button>'
        );
      } else {
        $(".m-footer").html(
          '<button type="button" class="btn btn-secondary-grey btn-save-done" data-dismiss="modal">Close</button>'
        );
      }
    } else {
      $(".m-footer").html("");
    }
  } else {
    $(".m-footer").html("");
  }

  if (typeof param.callback_function !== "undefined") {
    var func = param.callback_function;
    executeFunctionByName(func, window);
  }

  $("#msgmodal").modal("show");
}

//Occupation
function getActiveOccupations() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getActiveOccupations",
    },
    function (rs) {
      var l = "<option selected value='' >Select Occupation</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.name +
          "' data-name='" +
          val.name +
          "'>" +
          val.name +
          "</option>";
      });
      $(".sel-occupations").html(l);
    },
    "json"
  );
}

//locations
function getCountries() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getCountries",
    },
    function (rs) {
      var l = "<option selected value=''>Select Country</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.country_id +
          "'>" +
          val.country_name +
          "</option>";
      });
      $(".sel-country").html(l);
    },
    "json"
  );
}

function getRegions() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getRegions",
    },
    function (rs) {
      var l = "<option selected value='' >Select Region</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.location_count_id +
          "' data-name='" +
          val.location_name +
          "'>" +
          val.location_name +
          "</option>";
      });
      $(".sel-regions").html(l);
    },
    "json"
  );
}

function getProvinces() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getProvinces",
    },
    function (rs) {
      var l = "<option selected value=''>Select Province</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.location_count_id +
          "' data-name='" +
          val.location_name +
          "'>" +
          val.location_name +
          "</option>";
      });
      $(".sel-provinces").html(l);
    },
    "json"
  );
}

function getCities() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getCities",
    },
    function (rs) {
      var l = "<option selected value='' >Select City</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.location_count_id +
          "' data-name='" +
          val.location_name +
          "'>" +
          val.location_name +
          "</option>";
      });
      $(".sel-cities").html(l);
    },
    "json"
  );
}

function getBarangay() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getBarangay",
    },
    function (rs) {
      var l = "<option selected value='' >Select Barangay</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.location_count_id +
          "' data-name='" +
          val.location_name +
          "'>" +
          val.location_name +
          "</option>";
      });
      $(".sel-barangay").html(l);
    },
    "json"
  );
}

function getProvincesByRegionId(id) {
  $.post(
    sAjaxGlobalData,
    {
      type: "getProvinceByRegionID",
      region_id: id,
    },
    function (rs) {
      var l = "<option value='' selected>Select Province</option>";
      $.each(rs.data, function (key, val) {
        if (val.location_count_id) {
          l +=
            "<option value='" +
            val.location_count_id +
            "' data-name='" +
            val.location_name +
            "'>" +
            val.location_name +
            "</option>";
        }
      });
      $(".sel-provincesByRegionId").html(l);
    },
    "json"
  );
}

function getCityByProvinceId(id) {
  $.post(
    sAjaxGlobalData,
    {
      type: "getCityByProvinceId",
      province_id: id,
    },
    function (rs) {
      var l = "<option selected value='' >Select City</option>";
      $.each(rs.data, function (key, val) {
        if (val.location_count_id) {
          l +=
            "<option value='" +
            val.location_count_id +
            "' data-name='" +
            val.location_name +
            "'>" +
            val.location_name +
            "</option>";
        }
      });
      $(".sel-cities").html(l);
    },
    "json"
  );
}

function getBrgyByCityID(id) {
  $.post(
    sAjaxGlobalData,
    {
      type: "getBrgyByCityID",
      city_id: id,
    },
    function (rs) {
      var l = "<option selected value='' >Select Barangay</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.location_count_id +
          "' data-name='" +
          val.location_name +
          "'>" +
          val.location_name +
          "</option>";
      });
      $(".sel-barangay").html(l);
    },
    "json"
  );
}




function getSex() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getGlobalParameter",
      parameter_type: "sex",
    },
    function (rs) {
      var l = "<option selected value='' class='vi-sex'>Select Sex</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.parameter_count_id +
          "' data-name='" +
          val.parameter_name +
          "'>" +
          val.parameter_name +
          "</option>";
      });
      $(".sel-sex").html(l);
      //$(".sel-sex-select2").select2();
    },
    "json"
  );
}

function getAgenciesBranches() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getAgenciesBranches",
    },
    function (rs) {
      var l = "<option selected value='' >Select agency branchess</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.agency_branch_id +
          "'>" +
          val.name +
          "</option>";
      });
      $(".sel-agencies-branches").html(l);
    },
    "json"
  );
}

function getAssessmentServices() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getAssessmentServices",
    },
    function (rs) {
      var l = "<option selected value='' >Select service</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" + val.services_id + "'>" + val.name + "</option>";
      });
      $(".sel-assessment-services").html(l);
    },
    "json"
  );
}

function getCivilStatus() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getGlobalParameter",
      parameter_type: "civil",
    },
    function (rs) {
      var l = "<option selected value=''>Select Civil</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.parameter_count_id +
          "' data-name='" +
          val.parameter_name +
          "'>" +
          val.parameter_name +
          "</option>";
      });
      $(".sel-civil").html(l);
    },
    "json"
  );
}

function getCityByProvinceID(id) {
  $.post(
    sAjaxGlobalData,
    {
      type: "getCityByProvinceID",
      province_id: id,
    },
    function (rs) {
      var l = "<option selected value='' >Select City</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.location_count_id +
          "' data-name='" +
          val.location_name +
          "'>" +
          val.location_name +
          "</option>";
      });
      $(".sel-city").html(l);
    },
    "json"
  );
}

function getContactTypes() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getTransactionParameter",
      transaction_type: "contact",
    },
    function (rs) {
      var l = "<option selected value='' >Select Contact Type</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.transaction_parameter_count_id +
          "' data-name='" +
          val.transaction_parameter_name +
          "'>" +
          val.transaction_parameter_name +
          "</option>";
      });
      $(".sel-contact_type").html(l);
    },
    "json"
  );
}

function getReligions() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getGlobalParameter",
      parameter_type: "religion",
    },
    function (rs) {
      var l = "<option selected value='' >Select Religion</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.parameter_count_id +
          "' data-name='" +
          val.parameter_name +
          "'>" +
          val.parameter_name +
          "</option>";
      });
      $(".sel-religion").html(l);
    },
    "json"
  );
}

function getEducationalAttainments() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getGlobalParameter",
      parameter_type: "education",
    },
    function (rs) {
      var l = "<option selected value=''>Select Education</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.parameter_count_id +
          "' data-name='" +
          val.parameter_name +
          "'>" +
          val.parameter_name +
          "</option>";
      });
      $(".sel-education").html(l);
    },
    "json"
  );
}

function getFamilyRelations() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getGlobalParameter",
      parameter_type: "nextofkin",
    },
    function (rs) {
      var l = "<option selected value=''>Select Relationship</option>";
      var other = "";
      l = "<option value='0' selected disabled >Select Relationship</option>";
      $.each(rs.data, function (key, val) {
        var x = val.parameter_name;
        if (x.toLowerCase() == "other") {
          other =
            "<option value='" +
            val.parameter_count_id +
            "' data-name='" +
            val.parameter_name +
            "'>" +
            val.parameter_name +
            " </option>";
        } else {
          l +=
            "<option value='" +
            val.parameter_count_id +
            "' data-name='" +
            val.parameter_name +
            "'>" +
            val.parameter_name +
            " </option>";
        }
      });
      if (other != "") {
        l += other;
      }
      $(".sel-relation").html(l);
    },
    "json"
  );
}

function getCasePurposes() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getCaseTipDetails",
      case_tip: "purpose",
    },
    function (rs) {
      var l = "<option selected value='' >Type of Complaint</option>";
      $.each(rs.data, function (key, val) {
        l +=
          "<option value='" +
          val.tip_details_count +
          "' data-name='" +
          val.tip_details_name +
          "'>" +
          val.tip_details_name +
          "</option>";
      });
      $(".sel-traffic_purpose").html(l);
    },
    "json"
  );
}

function getNoDataFound(aParam) {
  l = "";
  l += '<div class=" text-center p-5 m-5" id="no-data_found"> ';
  l += '    <div class="nd-header">';
  l += "        <div>";
  l += '            <i class="fas fa-exclamation-triangle"></i>';
  l += "        </div>";
  l += "    </div>";
  l += '    <div class="nd-body">';
  l += '        <h5 class="nd-body-content ">';
  l += aParam.message;
  //l += '            SORRY, WE COULDN\'T FIND ANY CASE RELATED TO < span class = "font-italic" > "<span>keyword</span>" < /span>.';
  l += "        </h5>";
  l += "    </div>";
  l += '    <div class="nd-footer">';
  l += aParam.footer;
  //l += '        <button type="button" class="btn" style="background-color: #e88f15; color: #fff;"> ADD CASE </button>';
  l += "    </div>";
  l += "</div>";
  return l;
}

function executeFunctionByName(functionName, context /*, args */) {
  var args = Array.prototype.slice.call(arguments, 2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for (var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(context, args);
}

///global function for date
function dateViewingFormat(dt) {
  //ex : 2018-08-28
  if (dt !== "") {
    var monthNames = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];
    var year = dt.slice(0, 4);
    var month = parseInt(dt.slice(5, 7)) - 1;
    var days = dt.slice(8, 10);
    var newDateFormat = monthNames[month] + " " + days + ", " + year;
    return newDateFormat; //return : Aug 28, 2018
  } else {
    return "";
  }
}

///global function for date picker
function dateFormatToPicker(dt) {
  //ex : 2018-08-28
  var newDateFormat = "";
  if (!dt) {
    return newDateFormat;
  }
  var year = dt.slice(0, 4);
  var month = parseInt(dt.slice(5, 7)) - 1;
  month++;
  if (month <= 9) {
    month = "0" + month;
  }
  var days = dt.slice(8, 10);
  newDateFormat = month + "/" + days + "/" + year;
  return newDateFormat; //return : 08/28/2018
}

function localTime(time_val) {
  //ex : 20:28
  var hrs = parseInt(time_val.slice(0, 2));
  var mins = parseInt(time_val.slice(3, 5));
  var sec = parseInt(time_val.slice(6, 8));
  if (mins <= 9) {
    mins = "0" + mins;
  }
  if (sec <= 9) {
    sec = "0" + sec;
  }
  if (hrs >= 12 && mins >= 0) {
    if (hrs > 12) {
      hrs = hrs - 12;
    }
    return hrs + ":" + mins + ":" + sec + " PM"; //return : 8:28PM
  } else {
    return hrs + ":" + mins + ":" + sec + " AM"; //return : 8:28AM
  }
}

function getOffenderTypes() {
  $.post(
    sAjaxGlobalData,
    {
      type: "getTransactionParameter",
      transaction_type: "offender_type",
    },
    function (rs) {
      var l = "<option selected disabled>Select Offender Type</option>",
        other = "";

      $.each(rs.data, function (key, val) {
        var x = val.transaction_parameter_name;
        if (x.toLowerCase() == "other") {
          other =
            "<option value='" +
            val.transaction_parameter_count_id +
            "' data-name='" +
            val.transaction_parameter_name +
            "'>" +
            val.transaction_parameter_name +
            " </option>";
        } else {
          l +=
            "<option value='" +
            val.transaction_parameter_count_id +
            "' data-name='" +
            val.transaction_parameter_name +
            "'>" +
            val.transaction_parameter_name +
            " </option>";
        }
      });
      if (other != "") {
        l += other;
      }
      $(".sel-offender_type").html(l);
    },
    "json"
  );
}

function getPriorityTag(iTag) {
  switch (parseInt(iTag)) {
    case 1:
      sTag = "t_low";
      break;
    case 2:
      sTag = "t_medium";
      break;
    case 3:
      sTag = "t_high";
      break;
  }
  return sTag;
}

$('input[type="checkbox"]').click(function () {
  var ctr = 0;
  $(".chk-filter").each(function () {
    if ($(this).prop("checked") == true) {
      ctr++;
    }
  });

  // if (parseInt(ctr) >= 1) {
  //     $(".filter_action-btn").show();
  // } else {
  //     $(".filter_action-btn").hide();
  // }

  $(".filter_action-btn").show();

  if ($("#AN_1").prop("checked") == true) {
    $("#AN_2").prop("checked", false);
  } else if ($("#AN_2").prop("checked") == true) {
    $("#AN_1").prop("checked", false);
  }
});

function GetMonthName(monthNumber) {
  var months = [
    "JAN",
    "FEB",
    "MAR",
    "APR",
    "MAY",
    "JUN",
    "JUL",
    "AUG",
    "SEP",
    "OCT",
    "NOV",
    "DEC",
  ];
  return months[monthNumber - 1];
}

function getLoadingList() {
  $(".filter_load_placeholder").show();
  var l = "";
  var i;
  for (i = 0; i <= 10; i++) {
    l += ' <li  class="" style="width:100% ">';
    l += '    <div class="card" style="   ">';
    l += '        <div class="row">';
    l += '            <div class="col-lg-8 col-md-8 col-sm-8 details-col">';
    l += '               <div class="linear-background">';
    l += '                   <div class="inter-draw"></div>';
    l += '                   <div class="inter-crop"></div>';
    l += '                   <div class="inter-right--top"></div>';
    l += '                    <div class="inter-right--bottom"></div>';
    l += '                    <div class="inter-right--bottom2"></div>';
    l += '                    <div class="inter-right--bottom3"></div>';
    l += '                   <div class="inter-right--bottom4"></div>';
    l += '                   <div class="inter-right--bottom5"></div>';
    l += '                   <div class="inter-right--bottom6"></div>';
    l += '                   <div class="inter-right--bottom7"></div>';
    l += '                   <div class="inter-right--bottom8"></div>';
    l += '                   <div class="inter-right--bottom9"></div>';
    l += "                 </div>";
    l += "             </div>";
    l +=
      '           <div class="col-lg-2 col-md-2  col-sm-2 txt-align_center status-col"> ';
    l += '             <div class="linear-background">';
    l += '                   <div class="inter-draw"></div>';
    l += '                 <div class="inter-crop"></div>';
    l += '                 <div class="inter-right--top"></div>';
    l += "            </div>";
    l += "      </div>";
    l +=
      '       <div class="col-lg-2 col-md-2 col-sm-2 txt-align_center action-col">';
    l += '           <div class="linear-background">';
    l += '               <div class="inter-draw"></div>';
    l += '               <div class="inter-crop"></div>';
    l += '               <div class="inter-right--top"></div>';
    l += "          </div>";
    l += "      </div>";
    l += "  </div>";
    l += " </div>";
    l += " </li>";
  }
  $(".filter_load_placeholder").html(l);
}

//-------------- Hide Chartjs icon ----------------//
var parentElem = $("#id-66-title").parents();
$(parentElem[0]).addClass("hide");
var parentElem = $("#id-147-title").parents();
$(parentElem[0]).addClass("hide");
//-------------- Hide Chartjs icon ----------------//

// for delay
var delay = (function () {
  var timer = 0;
  return function (callback, ms) {
    clearTimeout(timer);
    timer = setTimeout(callback, ms);
  };
})();

function resetForm() {
  // reset form
  $("form").validate().resetForm();
  $("form")[0].reset();
  $("input").removeClass("error");
  $("textarea").removeClass("error");
}

function resetFormById(x) {
  // reset form
  $("#" + x)
    .validate()
    .resetForm();
  $("#" + x)[0].reset();
  $("#" + x + " input").removeClass("error");
  $("#" + x + " textarea").removeClass("error");
}

function removeErrorClass() {
  $("form").validate().resetForm();
  $("input").removeClass("error");
  $("textarea").removeClass("error");
  $("div.error").hide();
}

function resetFormJQueryValidation(sForm) {
  if (sForm) {
    $("#" + sForm)
      .validate()
      .resetForm();
  } else {
    $("form").validate().resetForm();
  }
  $("input").removeClass("error");
  $("select").removeClass("error");
}
