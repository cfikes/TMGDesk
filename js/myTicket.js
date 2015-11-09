function populateTicketInformation(){
    var ticketID = getUrlVars()["ticketid"];
    var email = getUrlVars()["email"];
    var requestURL = "api.php?call=myticketdetails&ticketid=" + ticketID + "&email=" + email;
    console.log(requestURL);
    $.getJSON(requestURL, function(json) {
        $("#fullName").html(json['FullName']);
        $("#telephone").html(json['Telephone']);
        $("#email").html(json['Email']);
        $("#issueType").html(json['IssueType']);
        $("#severity").html(json['Severity']);
        $("#issueDetails").html(json['Details']);
        if(json['Screenshot']==="NONE") { $("#screenshot").attr("src","img/noscreenshot.jpg"); } else { $("#screenshot").attr("src",json['Screenshot']); }
        $("#winUsername").html(json['MetaWinUser']);
        $("#winComputername").html(json['MetaComputer']);
        $("#remoteIP").html(json['MetaRemoteIP']);
        $("#status").html(json['Status']);
        $("#dateOpened").html(json['DateOpened']);
        $("#dateClosed").html(json['DateClosed']);
        $("#technician").html(json['Technician']);
        $("#tags").html(json['MetaTags']);
    });
}

function populateNotes(){
    var ticketID = getUrlVars()["ticketid"];
    var email = getUrlVars()["email"];
    var requestURL = "api.php?call=myticketnotes&ticketid=" + ticketID + "&email=" + email;;
    $.getJSON(requestURL, function(json) {
        $("#ticketNotes").html("");
        $.each(json.Notes, function(i,note) {
            var newNote = '<div class="uk-width-1-1 uk-margin-bottom ticketnote" noteID="' + note['NoteID'] + '"><article class="uk-article"><h3 class="uk-article-lead"><i class="uk-icon-user"></i> Public Note from ' + note['NoteAuthor'] + '</h3>' + note['Note'] + '<p class="uk-article-meta">' + note['NoteDate'] + '</p><hr class="uk-article-divider"></article><button class="uk-button" class="btnReplyNote" onclick="createNewNote(' + note['NoteID'] + ')">Reply</button>	<button class="uk-button" class="btnMarkSolution" onclick="markSolution(' + note['NoteID'] + ')">Mark Solution</button></div>';
            $("#ticketNotes").append(newNote);
        });
    });    
    
}

function assignNewStatus(pushedStatus){
    if(pushedStatus){
     var modal = UIkit.modal("#modalCloseTicket");
        if (modal.isActive()) {
            modal.hide();
        } else {
            modal.show();
        }
    }
}

function createNewNote(replyTo){
    $("#call").val("saveticketnote");
    if (replyTo){
        var requestURL = 'api.php?call=note&noteid=' + replyTo;
            $.getJSON(requestURL, function(json) {
                var note = "-----\n" + json['Note'] + "\n-----\n";
                $("#newNoteTitle").html("Reply to");
                $("#newNote").val(note);
        });
    } else {
        $("#newNoteTitle").html("New Note");
        $("#newNote").val("");
    }
    var modal = UIkit.modal("#modalNewNote");
        if (modal.isActive()) {
            modal.hide();
        } else {
            modal.show();
        }
}
function sendEmail(mailType){
    var emailFormData = {
        'call' : 'sendmail',
        'ticketid' : getUrlVars()["ticketid"],
        'email' : getUrlVars()["email"],
        'mailtype' : mailType
    };
    
    $.ajax({
        type : 'POST',
        url : 'api.php',
        data : emailFormData,
        dataType : 'json',
        encode : true,
        error : function(data){
            console.log(data);
            console.log("Emails Not Generated");
            UIkit.notify({
                'message':'Something went wrong.',
                'status':'danger',
                'timeout':2000,
                'pos':'top-center'
            });
        },
        success : function(data){
            console.log(data);
            var modal = UIkit.modal("#modalCloseTicket");
            modal.hide();
            var replaceButton = '<button type="button" class="uk-button uk-button-primary" id="btnSaveCloseTicket">Close Ticket</button>';
            $("#closeTicketTitle").html("Close Ticket");
            $("#closeTicketFooter").html(replaceButton);
            $("#closeNote").val("");
        }, timeout: 20000
    });
}

function closeTicket() {
        var formData = {
            'ticketid' : getUrlVars()["ticketid"],
            'call' : "closeticket",
            'visibility' : "Public",
            'note' : $("#closeNote").val(),
            'noteauthor' : $("#fullName").html(),
            'status' : 'Closed',
            'email' : getUrlVars()["email"]
        };
        console.log(formData);
        $.ajax({
                type : 'POST',
                url : 'api.php',
                data : formData,
                dataType : 'json',
                encode : true,
                error : function(){
                    console.log("Something Went Wrong");
                    UIkit.notify({
                        'message':'Something went wrong.',
                        'status':'danger',
                        'timeout':2000,
                        'pos':'top-center'
                    });
                },
                success : function(data){
                    sendEmail("closure");
                    populateNotes();
                    populateTicketInformation();
                    console.log(data);
                    if(data.Note === "Saved"){
                        UIkit.notify({
                            'message':'Generating Emails.',
                            'status':'success',
                            'timeout':2000,
                            'pos':'top-center'
                        });  
                    var replaceButton = '<div class="uk-progress uk-progress-striped uk-active"><div class="uk-progress-bar" style="width: 100%;">Updating Ticket Please Do Not Close</div></div>';
                    $("#closeTicketTitle").html("Closing Ticket");
                    $("#closeTicketFooter").html(replaceButton);
                    }
                }, timeout: 20000
        });
}

function saveNote(){
    var formData = {
            'ticketid' : getUrlVars()["ticketid"],
            'call' : $("#call").val(),
            'visibility' : 'Public',
            'note' : $("#newNote").val(),
            'noteauthor' : $("#fullName").html()
    };
    $.ajax({
            type : 'POST',
            url : 'api.php',
            data : formData,
            dataType : 'json',
            encode : true
    })
    .done(function(data) {
        console.log(data);
        if(data.Note === "Saved"){
            UIkit.notify({
                'message':'Note Saved.',
                'status':'success',
                'timeout':2000,
                'pos':'top-center'
            });
        sendEmail("note");
        populateNotes();
        } else {
            UIkit.notify({
                'message':'Something Went Wrong.',
                'status':'danger',
                'timeout':2000,
                'pos':'top-center'
            });
        }
    });
    $("#newNote").val("");
}

$(document).ready(function(){
   populateTicketInformation();
   populateNotes();
   //Monitors
   //

   //Monitor New Note
   $("#btnNewNote").click(function(){
       createNewNote();
   });
   
    //Monitor Reply
   $("#ticketNotes article").on('click', '.btnReplyNote', function(){
        var replyTo = $(this).parent().attr("noteID");
        console.log(replyTo);
        createNewNote(replyTo); 
   });
   
    //Monitor Close
   $("#btnCloseTicket").click(function(){
       assignNewStatus("Closed");
   });

    //Monitor Save Note
    $("#btnSaveNewNote").click(function(){
        var noteVisibility = "Public";
        var newNote = $("#newNote").val();
        if(noteVisibility && newNote){
            saveNote();
        } else {
            UIkit.notify({
            'message':'All Fields Required',
            'timeout':2000,
            'status':'warning',
            'pos':'top-center'
            });
        }
        var modal = UIkit.modal("#modalNewNote");
        modal.hide();
    });
    
    $("#btnSaveCloseTicket").click(function() {
        var closeNote = $("#closeNote").val();
        if(closeNote){
            closeTicket();
        } else {
            UIkit.notify({
            'message':'Provide a reason for closure.',
            'timeout':2000,
            'status':'warning',
            'pos':'top-center'
            });
        }
    });
});