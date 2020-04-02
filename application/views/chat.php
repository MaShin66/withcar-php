<style>
#message {
    margin: 8%;
    border: 3px solid black;
    padding: 6%;
    height: 600px;
    overflow: scroll;    
}

.submit_div {
    text-align: center;
}

#msg {
    border: 0;
    border-bottom: 1px solid black;
}


</style>

<div>
    <div id="message">
    </div>

</div>

<div class="submit_div">
    <input type="text" id="msg" div="input_div">
    <button type="button" id="chat_submit" onclick="chat_submit()">전송</button>
</div>


<input type="hidden" id="chat_id" value="<?=$return_chat['chat_id']?>">
<input type="hidden" id="is_driving" value="<?=$session_data['is_driving']?>">




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

            // var msg_length = return_msg['user_msg'].length + return_msg['driver_msg'].length;

            // console.log(msg_length);

            $('#message').html('<div></div>');

            var json_user_msg = JSON.parse(return_msg['user_msg'])
            var json_driver_msg = JSON.parse(return_msg['driver_msg'])

            if(is_driving === '1') {
                console.log('운전자');
                for(var key1 in json_driver_msg) {
                    for(var key2 in json_user_msg) {
                        if(key1 < key2) {
                            $('#message').append('<div style="text-align: right;">'+json_driver_msg[key1]+' '+key1.substr(11, 5)+'</div>');
                            delete json_driver_msg[key1];
                            break;
                        } else if(key1 >= key2) {
                            $('#message').append('<div style="text-align: left;">'+json_user_msg[key2]+' '+key2.substr(11, 5)+'</div>');
                            delete json_user_msg[key2];
                        }
                    }

                        var user_msg_keys = Object.keys(json_user_msg);
                        var driver_msg_keys = Object.keys(json_driver_msg);
                    
                        if(user_msg_keys.length == 0) { // 드라이버만 계속 보낼 때
                            $('#message').append('<div style="text-align: right;">'+json_driver_msg[key1]+' '+key1.substr(11, 5)+'</div>');
                        } else if(driver_msg_keys.length == 0) { // 탑승자만 계속 보낼 때
                            for(key2 in json_user_msg) {
                                $('#message').append('<div style="text-align: left;">'+json_user_msg[key2]+' '+key2.substr(11, 5)+'</div>');
                            }
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

                    if(driver_msg_keys.length == 0) {
                        $('#message').append('<div style="text-align: right;">'+key1.substr(11, 5)+' '+json_user_msg[key1]+'</div>');
                    } else if(user_msg_keys.length == 0) {
                        for(key2 in json_driver_msg) {
                            $('#message').append('<div style="text-align: left;">'+key2.substr(11, 5)+' '+json_driver_msg[key2]+'</div>');
                        }
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
            var yscroll = document.getElementById('message');
            yscroll.scrollTop = yscroll.scrollHeight;
        },
        error: function(request, status, error) {
            console.log('실패');
            console.log(request.responseText, status, error);
        }
    });
}

</script>