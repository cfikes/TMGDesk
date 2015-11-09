function populateTicketInformation(){
    var ticketID = getUrlVars()["ticketid"];
    var requestURL = "api.php?call=details&ticketid=" + ticketID;
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
        populateRemoteControl(json['MetaComputer'],json['MetaRemoteIP']);
        if(json['Status']==="Closed") { $("#ticketNotesFunctions").hide(); }
    });
}

function populateTechnicianList() {
    $.getJSON('api.php?call=technicians', function(json) {
        $.each(json.Technicians, function(i,tech) {
            var newTech = '<option>' + tech['name'] + '</option>';
            $("#listTechnicians").append(newTech);
        });
    });
}

function populateNotes(){
    var ticketID = getUrlVars()["ticketid"];
    var requestURL = "api.php?call=ticketnotes&ticketid=" + ticketID;
    $.getJSON(requestURL, function(json) {
        $("#ticketNotes").html("");
        $.each(json.Notes, function(i,note) {
            var newNote = '<div class="uk-width-1-1 uk-margin-bottom ticketnote" noteID="' + note['NoteID'] + '"><article class="uk-article"><h3 class="uk-article-lead"><i class="uk-icon-user"></i> Public Note from ' + note['NoteAuthor'] + '</h3>' + note['Note'] + '<p class="uk-article-meta">' + note['NoteDate'] + '</p><hr class="uk-article-divider"></article><span class="noteFunctions"><button class="uk-button" class="btnReplyNote" onclick="createNewNote(' + note['NoteID'] + ')">Reply</button>	<button class="uk-button" class="btnMarkSolution" onclick="markSolution(' + note['NoteID'] + ')">Mark Solution</button></span></div>';
            $("#ticketNotes").append(newNote);
        });
    });
}

function populateRemoteControl(computerName,remoteIP){
    var tableHeader = '<tr><th>Program</th><th>IP</th><th>DNS</th></tr>';
    $("#remoteControlTable").append(tableHeader);
    var tableRowDameware = '<tr><td>Dameware</td><td><a href="rc://' + remoteIP + '">' + remoteIP + '</a></td><td><a href="rc://' + computerName + '">' + computerName + '</a></td></tr>';
    $("#remoteControlTable").append(tableRowDameware);
    var tableRowRDP = '<tr><td>RDP</td><td><a href="RDP://' + remoteIP + '">' + remoteIP + '</a></td><td><a href="RDP://' + computerName + '">' + computerName + '</a></td></tr>';
  //  $("#remoteControlTable").append(tableRowRDP);
    var tableRowVNC = '<tr><td>VNC</td><td><a href="VNC://' + remoteIP + '">' + remoteIP + '</a></td><td><a href="VNC://' + computerName + '">' + computerName + '</a></td></tr>';
    $("#remoteControlTable").append(tableRowVNC);
}

function assignNewTechnician(){
    var modal = UIkit.modal("#modalNewTechnician");
        if (modal.isActive()) {
            modal.hide();
        } else {
            modal.show();   
        } 
}

function assignNewStatus(pushedStatus){
    if(pushedStatus){
        console.log("DetectedClosed");
        var modal = UIkit.modal("#modalCloseTicket");
        if (modal.isActive()) {
            modal.hide();
        } else {
            modal.show();   
        } 
    } else {
        $("#listNewStatus").html("<option>Awaiting Approval</option><option>Awaiting Parts</option>");
        $("#newStatusTitle").html("Assign New Status");
        $("#call").val("combonote");
        var modal = UIkit.modal("#modalNewStatus");
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

function openRemoteControl(){
    var modal = UIkit.modal("#modalRemoteControl");
        if (modal.isActive()) {
            modal.hide();
        } else {
            modal.show();
        }
}

function saveTechnician(newTech){
    var ticketID = getUrlVars()["ticketid"];
    var requestURL = "api.php?call=assign&ticketid=" + ticketID + "&technician=" + newTech;
    $.getJSON(requestURL, function(json) {
        if(json.Tech === "Saved"){
            UIkit.notify({
                'message':'Technician Assgned',
                'timeout':500,
                'status':'success',
                'pos':'top-center'
            });
            $("#technician").html(newTech);
            if(newTech === "Unassigned") { saveStatus(newTech); } else { saveStatus("Assigned"); }
        } else {
            console.log(json);
            UIkit.notify({
                'message':'Something Went Wrong',
                'timeout':2000,
                'status':'warning',
                'pos':'top-center'
            });
        }
    });
}

function saveStatus(newStatus) {
    if(newStatus==="Closed" || newStatus==="Awaiting Approval" || newStatus==="Awaiting Parts") {
        var formData = {
            'ticketid' : getUrlVars()["ticketid"],
            'call' : $("#call").val(),
            'visibility' : $("#listNoteVisibility").val(),
            'note' : $("#newStatusNote").val(),
            'noteauthor' : "System",
            'status' : newStatus
        };
        $.ajax({
                type : 'POST',
                url : 'api.php',
                data : formData,
                dataType : 'json',
                encode : true
        })
        .done(function(data) {
            console.log(data.Note);
            if(data.Note === "Saved"){
                UIkit.notify({
                    'message':'Note Saved.',
                    'status':'success',
                    'timeout':2000,
                    'pos':'top-center'
                });                    
            } else {
                UIkit.notify({
                    'message':'Something Went Wrong.',
                    'status':'danger',
                    'timeout':2000,
                    'pos':'top-center'
                });
            }
        });
    }else {
        var ticketID = getUrlVars()["ticketid"];
        var requestURL = "api.php?call=statuschange&ticketid=" + ticketID + "&status=" + newStatus;
        $.getJSON(requestURL, function(json) {
            if(json.Status === "Saved"){
                UIkit.notify({
                    'message':'New Status Assgned',
                    'timeout':500,
                    'status':'success',
                    'pos':'top-center'
                });
                $("#status").html(newStatus);

            } else {
                console.log(json);
                UIkit.notify({
                    'message':'Something Went Wrong',
                    'timeout':2000,
                    'status':'warning',
                    'pos':'top-center'
                });
            }
        });
        return;
    }
    UIkit.notify({
        'message':'Status Saved.',
        'status':'success',
        'timeout':2000,
        'pos':'top-center'
    });  
    $("#listNoteVisibility").val("Public");
    $("#newStatusNote").val("");
    populateTicketInformation();
    populateNotes();
}

    
function saveNote(){
    var formData = {
            'ticketid' : getUrlVars()["ticketid"],
            'call' : $("#call").val(),
            'visibility' : $("#listNoteVisibility").val(),
            'note' : $("#newNote").val(),
            'noteauthor' : "Technician"
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
        populateNotes();
        sendEmail("note");
        } else {
            UIkit.notify({
                'message':'Something Went Wrong.',
                'status':'danger',
                'timeout':2000,
                'pos':'top-center'
            });
        }
    });
    $("#listNoteVisibility").val("Public");
    $("#newNote").val("");
}


function closeTicket() {
	var formData = {
		'ticketid' : getUrlVars()["ticketid"],
		'call' : "closeticket",
		'visibility' : "Public",
		'note' : $("#closeNote").val(),
		'noteauthor' : "System",
		'status' : 'Closed',
		'email' : $("#email").html()
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

function sendEmail(mailtype){
    var emailFormData = {
        'call' : 'sendmail',
        'ticketid' : getUrlVars()["ticketid"],
        'email' : $("#email").html(),
        'mailtype' : mailtype
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

$(document).ready(function(){
   populateTicketInformation();
   populateNotes();
   populateTechnicianList();
   //Monitors
   //
   //Monitor New Tech
   $("#btnAssignTech").click(function(){
      assignNewTechnician();
   });
   
    //Monitor New Status
   $("#btnChangeStatus").click(function(){
      assignNewStatus(); 
   });
   
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
    //Monitor Close Save
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
   
    //Monitor Remote Control
   $("#btnRemoteControl").click(function(){
      openRemoteControl(); 
   });
   
   //Monitor Save Technician Button
   $("#btnSaveTechnician").click(function(){
        var newTech = $("#listTechnicians").val();
        if(newTech){
            saveTechnician(newTech);        
        } else {
            UIkit.notify({
            'message':'Close or select a technician.',
            'timeout':2000,
            'pos':'top-center'
            });
        }
        var modal = UIkit.modal("#modalNewTechnician");
        modal.hide();
    });
    
    //Monitor Save Status Button
    $("#btnSaveNewStatus").click(function(){
        var newStatus = $("#listNewStatus").val();
        var newStatusNote = $("#newStatusNote").val();
        if(newStatus && newStatusNote){
            saveStatus(newStatus);
            //saveNote(newStatusNote,"Public");
            
        } else {
            UIkit.notify({
            'message':'You must provide explanation.',
            'timeout':2000,
            'status':'warning',
            'pos':'top-center'
            });
        }
        var modal = UIkit.modal("#modalNewStatus");
        modal.hide();
    });
    
    $("#btnSaveNewNote").click(function(){
        var noteVisibility = $("#listNoteVisibility").val();
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
});