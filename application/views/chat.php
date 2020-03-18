<div id="chat_div">채팅 방</div>

출력창: <div id="message"></div>

입력창: <input type="text" id="msg">

<input type="hidden" id="chat_id" value="<?=$return_chat['chat_id']?>">
<input type="hidden" id="is_driving" value="<?=$session_data['is_driving']?>">

<button type="button" onclick="chat_submit()">전송</button>

<div>2020-03-18 13:05:51: "하이" (user)</div>
<div>2020-03-18 13:06:07: "안녕" (driver)</div>
<div>2020-03-18 13:15:42: "나도 안녕" (user)</div>
<div>2020-03-18 13:34:52: "나는 운전자" (driver)</div>
<div>2020-03-18 17:07:13: "내가 하나 더" (driver)</div>
<div>2020-03-18 17:07:16: "나도" (user)</div>

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
            var json_user_msg = JSON.parse(return_msg['user_msg'])
            var json_driver_msg = JSON.parse(return_msg['driver_msg'])
            if(is_driving === '1') {
                console.log('운전자');
                // $('#message').append('<div>'+$return_msg[key]+'</div>');
            } else if(is_driving === '0') {
                console.log('탑승자');

                // 2020-03-18 13:05:51: "하이" (user)
                // 2020-03-18 13:06:07: "안녕" (driver)
                // 2020-03-18 13:15:42: "나도 안녕" (user)
                // 2020-03-18 13:34:52: "나는 운전자" (driver)
                // 2020-03-18 17:07:13: "내가 하나 더" (driver)
                // 2020-03-18 17:07:16: "나도" (user)
                // console.log(json_user_msg);
                // console.log(json_driver_msg);

                
                
                for(var key1 in json_user_msg) {
                    // json_user_msg = {"1": "하이", "3": "나도 안녕", "6": "내가 하나 더"}
                    for(var key2 in json_driver_msg) {
                        // json_driver_msg = {"2": "안녕", "4": "나는 운전자", "5": "나도"}
                        if(key1 < key2) { // 1 < 2 // 3 < 4 // 6 < Undeifined
                            console.log(key1, json_user_msg[key1]);
                            delete json_user_msg[key1];
                        } else if(key1 >= key2) { // 3 >= 2 // 6 >= 4 // 6 >= 5
                            console.log(key2, json_driver_msg[key2]);
                            delete json_driver_msg[key2];
                        }
                    }
                    
                    var user_msg_keys = Object.keys(json_user_msg);
                    var driver_msg_keys = Object.keys(json_driver_msg);
                    
                    if(user_msg_keys.length === 1 && driver_msg_keys.length === 0) {
                        console.log(json_user_msg[key1]);
                    } else if(user_msg_keys.length === 0 && driver_msg_keys.length === 1) {
                        console.log(driver_msg_keys[key2]);
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