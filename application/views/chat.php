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
        success: function(return_msg) {

            $('#message').html('<div></div>');

            var json_user_msg = JSON.parse(return_msg['user_msg'])
            var json_driver_msg = JSON.parse(return_msg['driver_msg'])

            if(is_driving === '1') {
                console.log('운전자');
                for(var key1 in json_user_msg) {
                    for(var key2 in json_driver_msg) {
                        if(key1 < key2) {
                            $('#message').append('<div style="text-align: left;">'+key1.substr(11, 5)+' '+json_user_msg[key1]+'</div>');
                            delete json_user_msg[key1];
                            break;
                        } else if(key1 >= key2) {
                            $('#message').append('<div style="text-align: right;">'+key2.substr(11, 5)+' '+json_driver_msg[key2]+'</div>');
                            delete json_driver_msg[key2];
                        }
                    }
                    
                    var user_msg_keys = Object.keys(json_user_msg);
                    var driver_msg_keys = Object.keys(json_driver_msg);
                    
                    if(user_msg_keys.length == 1 && driver_msg_keys.length == 0) {
                        $('#message').append('<div style="text-align: left;">'+key1.substr(11, 5)+' '+json_user_msg[key1]+'</div>');
                    } else if(user_msg_keys.length == 0 && driver_msg_keys.length == 1) {
                        $('#message').append('<div style="text-align: right;">'+key2.substr(11, 5)+' '+json_driver_msg[key2]+'</div>');
                    }
                    
                }
            } else if(is_driving === '0') {
                console.log('탑승자');
                for(var key1 in json_user_msg) {
                    for(var key2 in json_driver_msg) {
                        if(key1 < key2) {
                            $('#message').append('<div style="text-align: right;">'+key1.substr(11, 5)+' '+json_user_msg[key1]+'</div>');
                            delete json_user_msg[key1];
                            break;
                        } else if(key1 >= key2) {
                            $('#message').append('<div style="text-align: left;">'+key2.substr(11, 5)+' '+json_driver_msg[key2]+'</div>');
                            delete json_driver_msg[key2];
                        }
                    }
                    
                    var user_msg_keys = Object.keys(json_user_msg);
                    var driver_msg_keys = Object.keys(json_driver_msg);
                    
                    if(user_msg_keys.length == 1 && driver_msg_keys.length == 0) {
                        $('#message').append('<div style="text-align: right;">'+key1.substr(11, 5)+' '+json_user_msg[key1]+'</div>');
                    } else if(user_msg_keys.length == 0 && driver_msg_keys.length == 1) {
                        $('#message').append('<div style="text-align: left;">'+key2.substr(11, 5)+' '+json_driver_msg[key2]+'</div>');
                    }
                    
                }
                
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