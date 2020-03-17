<div id="chat_div">채팅 방</div>

출력창: <div id="message"></div>

입력창: <input type="text" id="msg">

<input type="hidden" id="chat_id" value="<?=$return_chat['chat_id']?>">
<input type="hidden" id="is_driving" value="<?=$session_data['is_driving']?>">

<button type="button" onclick="chat_submit()">전송</button>


<script>

// setInterval("chat_get()", 1000);
setTimeout("chat_get()", 1000);

var chat_id = document.getElementById('chat_id').value;
var is_driving = document.getElementById('is_driving').value;

function chat_get() {
    $.ajax({
        url: '../chat_get',
        type: 'POST',
        data: { chat_id: chat_id },
        dataType: 'json',
        success: function($return_msg) {
            console.log($return_msg);
            if(is_driving === '1') {
                console.log('운전자');
                console.log(JSON.parse($return_msg['driver_msg']));
                // for(var key in $return_msg) {
                //     $('#message').append('<div>'+$return_msg[key]+'</div>');
                // }
            } else if(is_driving === '0') {
                console.log('운전자');
            }
            
        },
        error: function(request, status, error) {
            console.log(request.responseText, status, error);
        }
    });
}


function chat_submit() {
    var msg = document.getElementById('msg').value;

    $.ajax({
        url: '../chat_submit',
        type: 'POST',
        data: { chat_id: chat_id, msg: msg },
        dataType: 'json',
        success: function($return_msg) {
            console.log('성공');
            console.log($return_msg);
        },
        error: function(request, status, error) {
            console.log('실패');
            console.log(request.responseText, status, error);
        }
    });
}

</script>