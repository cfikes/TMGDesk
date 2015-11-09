function getUserName() {
    var requestURL = "api.php?call=username";
    $.ajaxSetup({ cache: false });
    $.getJSON(requestURL, function(data){ 
        if(data['username']){            
            var username = data['username'];
            $("#userWinUsername").val(username);
        }
    }).error(function(jqXHR, textStatus, errorThrown){
            return "NotAvailable";
    });
}

function getComputerName() {
    var requestURL = "api.php?call=computername";
    $.ajaxSetup({ cache: false });
    $.getJSON(requestURL, function(data){ 
        if(data.computername){
            var computername = data.computername;
            $("#userComputerName").val(computername);
        }
    }).error(function(jqXHR, textStatus, errorThrown){
            return "NotAvailable";
    });
}

function getRemoteIP() {
    var requestURL = "api.php?call=remoteip";
    $.ajaxSetup({ cache: false });
    $.getJSON(requestURL, function(data){ 
        if(data['remoteip']){
            var remoteip = data['remoteip'];
            $("#userRemoteIP").val(remoteip);
        }
    }).error(function(jqXHR, textStatus, errorThrown){
            return "NotAvailable";
    });
}

function populateForm() {
    getUserName();
    getComputerName();
    getRemoteIP();
}

function ticketSubmitted() {
    var completedForm = '<h1 class="uk-margin-top">Ticket Submitted</h1><p>You will receive an email confirmation shortly with more details</p>';
    $("#newTicketContainer").html(completedForm);
}


function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

$(document).ready(function() {
    
    populateForm();
    
    //Monitors
    $("#btnCreateTicket").click(function() {
        fullName = $("#userFullName").val();
        telephone = $("#userTelephone").val();
        emailAddress = $("#userEmail").val();
        issueType = $("#issueType").val();
        severity = $("#severity").val();
        issueDetails = $("#issueDetails").val();
        if (fullName){
        } else {
             UIkit.notify({
            'message':'<i class="uk-icon-warning"></i> A valid full name is required.',
            'timeout':2000,
            'status':'danger',
            'pos':'top-center'
            });
            return;
        }
        if (telephone){
        } else {
             UIkit.notify({
            'message':'<i class="uk-icon-warning"></i> A valid telephone number is required.',
            'timeout':2000,
            'status':'danger',
            'pos':'top-center'
            });
            return;
        }
        if (validateEmail(emailAddress)) {
        } else {
            UIkit.notify({
            'message':'<i class="uk-icon-warning"></i> A valid email address is required.',
            'timeout':2000,
            'status':'danger',
            'pos':'top-center'
            });
            return;
        }
        if (issueType){
        } else {
             UIkit.notify({
            'message':'<i class="uk-icon-warning"></i> Complete the issue summary.',
            'timeout':2000,
            'status':'danger',
            'pos':'top-center'
            });
            return;
        }
        if (severity){
        } else {
             UIkit.notify({
            'message':'<i class="uk-icon-warning"></i> Complete the issue summary.',
            'timeout':2000,
            'status':'danger',
            'pos':'top-center'
            });
            return;
        }
        if (issueDetails){
        } else {
             UIkit.notify({
            'message':'<i class="uk-icon-warning"></i> Please complete the issue details.',
            'timeout':2000,
            'status':'danger',
            'pos':'top-center'
            });
            return;
        }
        submitForm();
    });
    
function submitForm(){
    //$("form#newTicketForm").submit(function(event){
    //event.preventDefault();
    $("#btnCreateTicket").hide();
    var form = $("form#newTicketForm");
    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }

    var formAction = "createTicket.php";
    $.ajax({
        xhr: function()
        {
          var xhr = new window.XMLHttpRequest();
          //Upload progress
          xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              if (percentComplete === 1) { var statusMessage = "Generating Ticket Please Do Not Close"; } else { var statusMessage = percentComplete*100 + "%"; } 
              $("#fileProgress").css("width",percentComplete*100 + "%");
              $("#fileProgress").html(statusMessage);
            }
          }, false);
          //Download progress
          xhr.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              if (percentComplete === 1) { var statusMessage = "Generating Ticket Please Do Not Close"; } else { var statusMessage = percentComplete*100 + "%"; }
              $("#fileProgress").css("width",percentComplete*100 + "%");
              $("#fileProgress").html(statusMessage);
            }
          }, false);
          return xhr;
        },
        url         : formAction,
        data        : formdata ? formdata : form.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function (returndata) {
            //
        },
        error: function (returndata) {
            //console.log(returndata);//Present Error
        },
        complete: function (returndata) {
            //console.log(returndata);
            if (returndata.statusText === "OK") {
                ticketSubmitted();
            }
        }
    });
}
    

});