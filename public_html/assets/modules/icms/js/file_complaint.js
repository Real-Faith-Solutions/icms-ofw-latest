//------They comment the orignal code for validation of  // temporary_complainant_mobile_number: {required: true}, // temporary_complainant_preffered_contact_method: {required: true}, 
//         // temporary_complainant_email_address: {required: true},

// $('#file_complaint_form').validate({
//     rules: {
//         temporary_complainant_firstname: {required: true},
//         temporary_complainant_lastname: {required: true},
//         // temporary_complainant_mobile_number: {required: true},
//         // temporary_complainant_email_address: {required: true},
//         temporary_complainant_relation: {required: true},
//         temporary_complainant_address: {required: true},
//         // temporary_complainant_preffered_contact_method: {required: true}, 
//         // temporary_complain: {required: true},
//         temporary_complainant_complain: {required: true},

//         temporary_victim_firstname: {required: true},
//         temporary_victim_lastname: {required: true},
//         // temporary_victim_mobile_number: {required: true},
//         // temporary_victim_email_address: {required: true},
//         temporary_victim_dob: {required: true},
//         temporary_victim_address: {required: true},
//         temporary_victim_country_deployment: {required: true}, 
//         // temporary_complainant_preffered_contact_method: {required: true}, 
//         temporary_victim_civil_status: {required: true}, 
//         temporary_victim_departure_type: {required: true},
//         temporary_victim_sex: {required: true}
//     },

$('#file_complaint_form').validate({
    rules: {
        temporary_complainant_firstname: {required: true},
        temporary_complainant_lastname: {required: true},
        temporary_complainant_mobile_number: {required: true},
        temporary_complainant_email_address: {required: true},
        temporary_complainant_relation: {required: true},
        temporary_complainant_address: {required: true},
        temporary_complainant_preffered_contact_method: {required: true}, 
        temporary_complain: {required: true},
        temporary_complainant_complain: {required: true},

        temporary_victim_firstname: {required: true},
        temporary_victim_lastname: {required: true},
        temporary_victim_mobile_number: {required: true},
        temporary_victim_email_address: {required: true},
        temporary_victim_dob: {required: true},
        temporary_victim_address: {required: true},
        temporary_victim_country_deployment: {required: true}, 
        temporary_complainant_preffered_contact_method: {required: true}, 
        temporary_victim_civil_status: {required: true}, 
        temporary_victim_departure_type: {required: true},
        temporary_victim_sex: {required: true}
    },
    errorElement: 'div',
    errorPlacement: function (error, element) { 
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function (form) {

        add_complaint();
        ConfirmationGmail();
    }
});

function add_complaint() {
    let data =  dg__objectAssign({
        type: "addFileComplaint",
        is_victim: $('#file_complaint_form').attr('d-id')
        
    },
        dg__getFormValues({
            type: "obj",
            form: "#file_complaint_form"
        })
    );

    $.post(sAjaxWebPublic,data, function (rs) {
        icmsMessage({
            type: 'msgPreloader',
            visible: true
        });
        if (rs.data.flag != '0') {
            icmsMessage({
                type: 'msgSuccess'
            });
            // console.log(window.location.protocol + '/verification?tcn='+ rs.data.tcn + '&code=' + rs.data.otp_details.otp_code);
            // window.location.assign(window.location.protocol + '/verification?code=' + rs.data.otp_details.otp_code +'&tcn='+ rs.data.tcn);
            window.location.assign(window.location.protocol + '/result_page?tcid='+ rs.data.tcid + '&ovc='+ rs.data.otp_details.otp_code);
        } else {
            icmsMessage({
                type: 'msgError'
            });
        }
    }, 'json');
}

// add gmail

function ConfirmationGmail() {
    let data =  dg__objectAssign({
        type: "ConfirmationGmail",
        is_victim: $('#file_complaint_form').attr('d-id')
        
    },
        dg__getFormValues({
            type: "obj",
            form: "#file_complaint_form"
        })
    );

    $.post(sAjaxWebPublic, data, function (rs) {
        icmsMessage({
            type: 'msgPreloader',
            visible: true
        });
        if (rs.data.flag != '0') {
            icmsMessage({
                type: 'msgSuccess'
            });
            // Trigger ConfirmationGmail function upon successful complaint submission
            $.ajax({
                url: 'icms.iacat-icms.test/file_complaint/ConfirmationGmail', // Replace with your server-side endpoint URL
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Log the response from the server
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log any errors
                }
            });
            // Redirect to result page
            window.location.assign(window.location.protocol + '/result_page?tcid='+ rs.data.tcid + '&ovc='+ rs.data.otp_details.otp_code);
        } else {
            icmsMessage({
                type: 'msgError'
            });
        }
    }, 'json');
}



$(document).ready(function () {

    $('#q_modal').modal({
        keyboard: false,
        backdrop: 'static',
        show: true
      });

       // date picker 
    $('.datepicker').datetimepicker({
        timepicker: false,
        format: 'm/d/Y',
        scrollMonth: false,
        scrollInput: false
    });


      var check = 0;

      // $('#is_victim').on('change', function() {
      //      check = this.checked ? this.value : '0';
          
      //     if (check == '1') {
      //         $('.c-dt').attr('disabled', true);
      //         $('#inp-temporary_complainant_relation').val(2);
      
      //         // copy complainant details
      //         $('#inp-temporary_victim_firstname').val($('#inp-temporary_complainant_firstname').val());
      //         $('#inp-temporary_victim_lastname').val($('#inp-temporary_complainant_lastname').val());
      //         $('#inp-temporary_victim_mobile_number').val($('#inp-temporary_complainant_mobile_number').val());
      //         $('#inp-temporary_victim_middlename').val($('#inp-temporary_complainant_middlename').val());
      //         $('#inp-temporary_victim_email_address').val($('#inp-temporary_complainant_email_address').val());
              
      //     } else {
      //         $('.c-dt').attr('disabled', false);
      //         $('#inp-temporary_complainant_relation').val('');
      //     }
      
      // });
      
      $('#q_modal_y').click(function () {
          $('#q_modal').modal('hide');
          $('#file_complaint_form').attr('d-id', '1');
          $('.c-dt').attr('disabled', true);
          $('#inp-temporary_complainant_relation').val(6);
          $('.masthead-content').show();
          check = 1;
          
      });
      
      $('#q_modal_n').click(function () {
          $('#q_modal').modal('hide');
          $('#file_complaint_form').attr('d-id', '0');
          $('.masthead-content').show();
      });

    $('#inp-temporary_victim_firstname').on('keyup', () => {
        if (check == '1') {
            $('#inp-temporary_complainant_firstname').val($('#inp-temporary_victim_firstname').val());
        }
    });

    $('#inp-temporary_victim_lastname').on('keyup', () => {
        if (check == '1') {
            $('#inp-temporary_complainant_lastname').val($('#inp-temporary_victim_lastname').val());
        }
    });

    $('#inp-temporary_victim_mobile_number').on('keyup', () => {
        if (check == '1') {
            $('#inp-temporary_complainant_mobile_number').val($('#inp-temporary_victim_mobile_number').val());
        }
    });

    $('#inp-temporary_victim_middlename').on('keyup', () => {
        if (check == '1') {
            $('#inp-temporary_complainant_middlename').val($('#inp-temporary_victim_middlename').val());
        }
    });

    $('#inp-temporary_victim_email_address').on('keyup', () => {
        if (check == '1') {
            $('#inp-temporary_complainant_email_address').val($('#inp-temporary_victim_email_address').val());
        }
    });

});



