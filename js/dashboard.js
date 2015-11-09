function drawChartNewTickets() {
  $.getJSON('js/newTickets.json', function(json) {
    var data = new google.visualization.DataTable(json);
    var options = {
        title: 'New Tickets',
        curveType: 'function',
        colors:['red'],
        legend: { position: 'none' }
    };
    var chart = new google.visualization.LineChart(document.getElementById('openTickets'));
    chart.draw(data, options);
    });
}

function drawChartClosedTickets() {
  $.getJSON('js/closedTickets.json', function(json) {
    var data = new google.visualization.DataTable(json);
    var options = {
        title: 'Closed Tickets',
        curveType: 'function',
        colors:['green'], 
        legend: { position: 'none' }
    };
    var chart = new google.visualization.LineChart(document.getElementById('closedTickets'));
    chart.draw(data, options);
    });
}

function drawTableOldestTickets() {
    $("#oldestTicketsTable").html("");
    var requestURL = "api.php?call=oldest";
    $.getJSON(requestURL, function(json) {
        var tableHeading = '<thead><tr><th>Date Opened</th><th>User</th><th>Status</th></tr></thead>';
        $("#oldestTicketsTable").html(tableHeading);
        $.each(json.tickets, function(i,ticket) {
            var tableRow = '<tr class="individualTicket" id="' + ticket['ID'] + '"><td>' + ticket['DateOpen'] + '</td><td>' + ticket['Creator'] + '</td><td>' + ticket['Status'] +'</td></tr>';
            $("#oldestTicketsTable").append(tableRow);
        });
    });
}

function drawTableTodayTickets() {
    $("#todayTicketsTable").html("");
    var requestURL = "api.php?call=report&reportname=day";
    $.getJSON(requestURL, function(json) {
        var tableHeading = '<thead><tr><th>Date Opened</th><th>User</th><th>Status</th></tr></thead>';
        $("#todayTicketsTable").html(tableHeading);
        $.each(json.tickets, function(i,ticket) {
            var tableRow = '<tr class="individualTicket" id="' + ticket['ID'] + '"><td>' + ticket['Creator'] + '</td><td>' + ticket['Status'] +'</td><td>' + ticket['Severity'] + '</td></tr>';
            $("#todayTicketsTable").append(tableRow);
        });
    });
}

function drawTableUnassignedTickets() {
    $("#unassignedTicketsTable").html("");
    var requestURL = "api.php?call=unassigned";
    $.getJSON(requestURL, function(json) {
        var tableHeading = '<thead><tr><th>Date Opened</th><th>User</th><th>Status</th></tr></thead>';
        $("#unassignedTicketsTable").html(tableHeading);
        $.each(json.tickets, function(i,ticket) {
            var tableRow = '<tr class="individualTicket" id="' + ticket['ID'] + '"><td>' + ticket['DateOpen'] + '</td><td>' + ticket['Creator'] + '</td><td>' + ticket['Status'] +'</td></tr>';
            $("#unassignedTicketsTable").append(tableRow);
        });
    });
}

function loadTicketDetails() {
    
}

$(document).ready(function(){
    drawTableOldestTickets();
    drawTableUnassignedTickets();
    drawTableTodayTickets();
    google.setOnLoadCallback(drawChartNewTickets);
    google.setOnLoadCallback(drawChartClosedTickets);

    
    $("#refreshOldest").click(function(){
        drawTableOldestTickets();
    });
    $("#refreshUnassigned").click(function(){
        drawTableUnassignedTickets();
    });
    $("#refreshToday").click(function(){
        drawTableTodayTickets();
    });
    $("#oldestTicketsTable").on('click','.individualTicket', function(){
       var ticketURL = "existingTicket.php?call=details&ticketid=" + $(this).attr("id");
       window.location.assign(ticketURL);
    });
    $("#unassignedTicketsTable").on('click','.individualTicket', function(){
       var ticketURL = "existingTicket.php?call=details&ticketid=" + $(this).attr("id");
       window.location.assign(ticketURL);
    });
    $("#todayTicketsTable").on('click','.individualTicket', function(){
       var ticketURL = "existingTicket.php?call=details&ticketid=" + $(this).attr("id");
       window.location.assign(ticketURL);
    });
    
});