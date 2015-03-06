$(function() {
    $("#tabs").tabs();
});
$(function() {
    
    $("#member_form").validate({
        
        rules: {
            name: {
                required: true,
                name_validate: true
            },
            dob: {
                required: true,
                dob_validate: true
            },
            phoneNo1: {
                required: true,
                phoneNo_validate: true

            },            
            address: {
                required: true
            },
            email: {
                required: true,
                email: true
            }

        },
        messages: {
            name: {
                required: "Enter your name."
            },
            dob: {
                required: "Enter date of birth."
            },
            phoneNo1: {
                required: "Enter your phone number.",
            },
            phoneNo3: {
                required: "Enter your home phone number.",
            },
            address: {
                required: "Enter your address."
            },
            email: {
                required: "Enter your email address."
            }
        }
    });
    $.validator.addMethod("name_validate",
            function(value, element) {
                return /^[a-zA-Z ]+$/.test(value);
            },
            "Enter your name correctly!"
            );
    $.validator.addMethod("phoneNo_validate",
            function(value, element) {

                return /^[0-9\d+-]+$/.test(value);


            },
            "Enter phone number correctly!"
            );
    $.validator.addMethod("dob_validate",
            function(value, element) {
                return /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(value);
            },
            "Enter date YYYY-MM-DD format!"
            );
});

function validate_tel2() {
    var telno1 = document.getElementsByName("phoneNo1")[0].value;
    var telno2 = document.getElementsByName("phoneNo2")[0].value;
    var phoneno = /^[0-9\d+-]+$/;



    if (phoneno.test(telno2) == false)
    {
        document.getElementById("telno2").innerHTML = "Enter valid phone number.";
        tel2.focus();
    }
    else
    {
        if (telno1 == telno2) {
            document.getElementById("telno2").innerHTML = "Enter different phone number.";
            tel2.focus();
        } else {
            document.getElementById("telno2").innerHTML = "";
        }

    }
}
function validate_tel3() {   
    var telno3 = document.getElementsByName("phoneNo3")[0].value;
    var phoneno = /^[0-9\d+-]+$/;



    if (phoneno.test(telno3) == false)
    {
        document.getElementById("telno3").innerHTML = "Enter valid phone number.";
        tel3.focus();
    }
    else
    {
      
            document.getElementById("telno3").innerHTML = "";
        

    }
}

$(document).ready(function(){
    $('#myTable').dataTable();
});










