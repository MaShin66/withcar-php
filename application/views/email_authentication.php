<style>
.form-horizontal {
    left: 10%;
    top: 22%;
    position: absolute;
    width: 80%;
    font-size: 2.4rem;
}
</style>

<form class="form-horizontal" action="email_signup" method="post">
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">이메일 주소</label>
    
    <div class="col-sm-10">
      <input type="email" class="form-control" id="email" name="email" placeholder="abc@gmail.com" onkeyup="email_check()">
    </div>
  </div>

  <div id="alert_div"></div>

  <div id="code_button" class="form-group"></div>

  <div id="code_div"></div>
  
  <div id="submit_div" class="form-group"></div>
</form>


<script>

function email_check() {
    var email = document.getElementById('email').value;
    if(email == '') {
        document.getElementById('alert_div').innerHTML = '';
        document.getElementById('code_button').innerHTML = '';
    } else if(email.indexOf('@') == -1) {
        document.getElementById('alert_div').innerHTML = '@의 메일 형식이 필요합니다.';
        document.getElementById('code_button').innerHTML = '';
    } else {
        $.ajax({
        url: "/index.php/withcar/email_check/" + email,
        type: 'POST',
        dataType: 'json',
        // data: id, 이상하게 안됨
        success: function($return_value) {
            if(!$return_value) {
                document.getElementById('alert_div').innerHTML = '아이디로 사용할 수 있습니다.';
                document.getElementById('code_button').innerHTML = '<div class="col-sm-offset-2 col-sm-10"><button type="button" class="btn btn-default" onclick="email_send()">인증번호 받기</button></div>';
            } else {
                document.getElementById('alert_div').innerHTML = '중복된 아이디입니다.';
                document.getElementById('code_button').innerHTML = '';
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


var code = Math.floor(Math.random()*9000+1000);

function email_send() {
    var email = document.getElementById('email').value;

    $.ajax({
        url: '/index.php/withcar/email_send/' + email + '/' + code,
        type: 'POST',
        dataType: 'json',
        success: function($code) {
            console.log($code);
            document.getElementById('code_div').innerHTML = '인증번호입력 <input type="text" name="code" id="code"></input><br><br><button type="button" onclick="code_check()">인증번호 확인</button>';
        },
        error: function(request, status, error) {
            console.log(request.responseText, status, error);
        }
    });
}

function code_check() {
  console.log(document.getElementById('code').value, code);
  if(document.getElementById('code').value == code) {
    console.log('인증 성공');
    document.getElementById('submit_div').innerHTML = '<div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-default">회원가입</button></div>';
  } else {
    alert('인증번호가 틀렸습니다.');
  }
}

</script>