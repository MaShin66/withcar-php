<!-- <?php
    var_dump($session_data);
    var_dump($ride_id);
    var_dump($chat_id);
?> -->

<div id="chat_div">채팅 방</div>

출력창: <div id="message"></div>

입력창: <input type="text" id="user_msg">
<button type="button" onclick="chat_submit()">전송</button>

<script>
var user_msg = document.getElementById('user_msg').value;
var ride_id = <?=$ride_id?>;

console.log(ride_id);

// function chat() {
//     $.ajax({
//         url: '',
//         type: 'POST',
//         data: { chat_id: chat_id },
//         dataType: 'json',
//         success: function($return_msg) {
//             console.log($return_msg);
//             for(var key in $return_msg) {
//                 console.log(key);
//                 console.log($return_msg[key]);
//                 $('#message').html('<div>'+key+'</div>');
//             }
//         },
//         error: function(request, status, error) {
//             console.log(request.responseText, status, error);
//         }
//     });
// }


// function chat_submit() {
//     $.ajax({
//         url: 'chat_db',
//         type: 'POST',
//         data: { user_msg: user_msg },
//         dataType: 'json',
//         success: function($return_msg) {
//             console.log('성공');
//             console.log($return_msg);
//             for(var key in $return_msg) {
//                 console.log(key);
//                 console.log($return_msg[key]);
//                 $('#message').html('<div>'+key+'</div>');
//             }
//         },
//         error: function(request, status, error) {
//             console.log('실패');
//             console.log(request.responseText, status, error);
//         }
//     });
// }

</script>