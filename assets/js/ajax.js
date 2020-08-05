$( document ).ready(function() {
    $("#signin").click(
        function(){
            sendLogin('result', 'ajax_login', 'engine/user.php?m=login');
            return false;
        }
    );
});

$( document ).ready(function() {
    $("#signup").click(
        function(){
            sendReg('result', 'ajax_reg', 'engine/user.php?m=reg');
            return false;
        }
    );
});

function sendLogin(result, ajax_login, url) {
    $.ajax({
        url:     url,
        type:     "POST",
        dataType: "json",
        data: $("#"+ajax_login).serialize(),
        success: function(data){
            switch(data.status){
                case true:
                    $('#result').html('Hello '+data.name);
                    break;
                case false:
                    $('#result').html(data.result);
                    break;
            }
        }
    });
}

function sendReg(result, ajax_reg, url) {
    $.ajax({
        url:     url,
        type:     "POST",
        dataType: "json",
        data: $("#"+ajax_reg).serialize(),
        success: function(data){
            switch(data.status){
                case true:
                    $('#result').html('Вы успешно зарегистрировались!');
                    break;
                case false:
                    $('#result').html(data.result);
                    break;
            }
        }
    });
}