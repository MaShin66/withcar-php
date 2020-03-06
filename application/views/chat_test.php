<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<div id="chat_div">채팅 테스트</div>

입력창: <input type="text" id="user_msg" value="테스트">
<button type="button" onclick="chat_submit()">전송</button>

<input type="hidden" value="<?=$user_id?>">
<input type="hidden" value="<?=$driver_id?>">

<!-- <input type="hidden" value="<?=$user_name?>">
<input type="hidden" value="<?=$driver_name?>"> -->

<script>
var user_id = '<?=$user_id?>';
var user_name = '신짱';
var user_msg = document.getElementById('user_msg').value;

function chat_submit() {
    $.ajax({
        url: 'chat_db',
        type: 'POST',
        data: { user_id: user_id, user_msg: user_msg, user_name: user_name },
        dataType: 'json',
        success: function($return_msg) {

        },
        error: function(request, status, error) {
            console.log(request.responseText, status, error);
        }
    });
}

</script>