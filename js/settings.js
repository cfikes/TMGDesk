function populateSettings(){
    $.getJSON("api.php?call=adminsettings", function(setting) {
        document.getElementById("Name").value = setting['Name'];
        document.getElementById("BaseURL").value = setting['BaseURL'];
        document.getElementById("Company").value = setting['Company'];
        document.getElementById("SupportE").value = setting['SupportE'];
        document.getElementById("SupportT").value = setting['SupportT'];
        document.getElementById("SMTPServer").value = setting['SMTPServer'];
        document.getElementById("SMTPUsername").value = setting['SMTPUsername'];
        document.getElementById("SMTPPassword").value = setting['SMTPPassword'];
        document.getElementById("SMTPSecurity").value = setting['SMTPSecurity'];
        document.getElementById("SMTPPort").value = setting['SMTPPort'];
        document.getElementById("MYSQLServer").value = setting['MYSQLServer'];
        document.getElementById("MYSQLPort").value = setting['MYSQLPort'];
        document.getElementById("MYSQLDatabase").value = setting['MYSQLDatabase'];
        document.getElementById("MYSQLUsername").value = setting['MYSQLUsername'];
        document.getElementById("MYSQLPassword").value = setting['MYSQLPassword'];
    });
    
    $.getJSON("api.php?call=mysettings", function(setting) {
        console.log(setting['Name']);
        document.getElementById("myName").value = setting['Name'];
    });
}

function saveSettings(){
    var form = $("form#settingsForm");
    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }

    var formAction = "configurationWriter.php";
    $.ajax({
        url         : formAction,
        data        : formdata ? formdata : form.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function (returndata) {
        },
        error: function (returndata) {
        },
        complete: function (returndata) {
            if (returndata.statusText === "OK") {
            UIkit.notify({
                'message':'Settings Updated.',
                'timeout':2000,
                'pos':'top-center',
                'status':'success'
            });
            }
        }
    });
}

function saveMySettings(){
    var form = $("form#mySettingsForm");
    var formdata = false;
    if (window.FormData){
        formdata = new FormData(form[0]);
    }

    var formAction = "api.php";
    $.ajax({
        url         : formAction,
        data        : formdata ? formdata : form.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function (returndata) {
        },
        error: function (returndata) {            
        },
        complete: function (returndata) {
            if (returndata.statusText === "OK") {
            UIkit.notify({
                'message':'My Settings Updated.',
                'timeout':2000,
                'pos':'top-center',
                'status':'success'
            });
            }
        }
    });
}

$(document).ready(function() {
    populateSettings();
    $("#saveSettings").click(function(){
        saveSettings();
    });    
    $("#saveMySettings").click(function(){
        saveMySettings();
    });
});