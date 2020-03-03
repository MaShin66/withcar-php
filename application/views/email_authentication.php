<style>
.form-horizontal {
    left: 10%;
    top: 22%;
    position: absolute;
    width: 80%;
    font-size: 2.4rem;
}
</style>

<form class="form-horizontal" action="" method="post">
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">이메일 주소</label>
    
    <div class="col-sm-10">
      <input type="email" class="form-control" id="email" name="email" placeholder="abc@gmail.com" onkeyup="email_check()">
    </div>
  </div>

  <div id="alert_div"></div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="button" class="btn btn-default" onclick="email_send()">인증번호 받기</button>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">회원가입</button>
    </div>
  </div>
</form>

<script>

function email_check() {
    var email = document.getElementById('email').value;
    if(email == '') {
        document.getElementById('alert_div').innerHTML = '';
    } else if(email.indexOf('@') == -1) {
        document.getElementById('alert_div').innerHTML = '@ 를 가진 메일 형식이 필요합니다.';
    } else {
        $.ajax({
        url: "/index.php/withcar/email_check/" + email,
        type: 'POST',
        dataType: 'json',
        // data: id, 이상하게 안됨
        success: function($return_value) {
            if(!$return_value) {
                document.getElementById('alert_div').innerHTML = '아이디로 사용할 수 있습니다.'
            } else {
                document.getElementById('alert_div').innerHTML = '중복된 아이디입니다.';
            }
        },
        error: function(request, status, error) {
            console.log(request.responseText);
            console.log(status);
            console.log(error);
        }
    });
    }
}

function email_send() {
    var email = document.getElementById('email').value;
    $.ajax({
        url: '/index.php/withcar/email_send/' + email,
        type: 'POST',
        dataType: 'json',
        success: function($return) {
            console.log('일단 성공');
            console.log($return);
        },
        error: function(request, status, error) {
            console.log(request.responseText);
            console.log(status);
            console.log(error);
        }
    });
}
</script>