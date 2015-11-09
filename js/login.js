function submitLogin(){
    var formData = {
            'username' : $("#username").val(),
            'password' : $("#password").val(),
            'call' : "login"
    };
    console.log(formData);
    $.ajax({
            type : 'POST',
            url : 'api.php',
            data : formData,
            dataType : 'json',
            encode : true,
            success : function(data){
                console.log(data);
                if(data.session === "valid"){
                window.location.replace("dashboard.php");  
                } else {
                    UIkit.notify({
                        'message':'Invalid Login.',
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
    
}

$(document).ready(function(){
   $("#btnLogin").click(function(){
       console.log("Clicked");
       submitLogin();
   });
   
   $('#password').keypress(function (e) {
        var key = e.which;
        if(key === 13) {
           $("#btnLogin").click();
           return false;  
        }
    }); 
});
