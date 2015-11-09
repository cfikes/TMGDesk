function drawReport(report,reportTitle) {
    $("#renderArea").html("");
    $("#reportTitle").html(reportTitle);
    var requestURL = "api.php?call=report&reportname=" + report;
    $.getJSON(requestURL, function(json) {
        var tableHeading = '<thead><tr><th>Date Opened</th><th>User</th><th>Type</th><th>Technician</th><th>Severity</th><th>Status</th></tr></thead>';
        $("#renderArea").html(tableHeading);
        $.each(json.tickets, function(i,ticket) {
            var tableRow = '<tr class="individualTicket" id="' + ticket['ID'] + '"><td>' + ticket['DateOpen'] + '</td><td>' + ticket['Creator'] + '</td><td>' + ticket['IssueType'] + '</td><td>' + ticket['Technician'] + '</td><td>'+ ticket['Severity'] + '</td><td>' + ticket['Status'] +'</td></tr>';
            $("#renderArea").append(tableRow);
        });
    });
}

function deleteTicket(){
    var formData = {
            'ticketid' : $("#ticketIDforRemoval").val(),
            'call' : "deleteticket"
    };
    $.ajax({
            type : 'POST',
            url : 'api.php',
            data : formData,
            dataType : 'json',
            encode : true,
            success : function(data){
                console.log(data);
                if(data.Ticket === "Deleted"){
                    UIkit.notify({
                        'message':'Ticket Deleted',
                        'status':'success',
                        'timeout':2000,
                        'pos':'top-center'
                    });
                    var modal = UIkit.modal("#deleteTicketModal");
                    modal.hide();
                } else {
                    console.log(data);
                    UIkit.notify({
                        'message':'Something went wrong.',
                        'status':'danger',
                        'timeout':2000,
                        'pos':'top-center'
                    });
                }
            },
            error : function(data){
                console.log(data);
            }
    });
    $("#ticketIDforRemoval").val("");
    $("#deleteVerify").val("");
}

$(document).ready(function(){
   //Monitor Report Click
    $(".btnReport").click(function(){
       var report = $(this).attr("report");
       var reportTitle = $(this).html();
       console.log(report,reportTitle);
       drawReport(report,reportTitle);
   });
   
   //Monitor Click Individual Ticket
    $("#renderArea").on('click','.individualTicket', function(){
        var ticketURL = "existingTicket.php?call=details&ticketid=" + $(this).attr("id");
        window.location.assign(ticketURL);
    });    
    
    //Monitor Delete Ticket Button
    $("#bntDeleteTicket").click(function(){
        var ticketid = $("#ticketIDforRemoval").val();
        var verification = $("#deleteVerify").val();
        if(ticketid && verification){
            if(verification!=="YES"){
                UIkit.notify({
                    'message':'YOU MUST TYPE YES',
                    'status':'danger',
                    'timeout':2000,
                    'pos':'top-center'
                });
            } else {
                deleteTicket(ticketid);
            }
        } else {
            UIkit.notify({
                'message':'YOU MUST FILL OUT COMPLETELY',
                'status':'danger',
                'timeout':2000,
                'pos':'top-center'
            });
        }
    });
});
