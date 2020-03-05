<style>
.form-horizontal {
    left: 10%;
    top: 22%;
    position: absolute;
    width: 80%;
    font-size: 2.4rem;
}
</style>

<form class="form-horizontal" action="email_signup2" method="post">
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">이메일 주소</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="email" name="email" value=<?=$email_id?> readonly>
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">비밀번호</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" name="password">
    </div>
  </div>
  <div class="form-group">
    <label for="user_name" class="col-sm-2 control-label">이름</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="user_name" name="user_name">
    </div>
  </div>
  <div class="form-group">
    <label for="student_id" class="col-sm-2 control-label">학번</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="student_id" name="student_id">
    </div>
  </div>
  <div class="form-group">
    <label for="phone" class="col-sm-2 control-label">휴대폰 번호</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="phone" name="phone" placeholder="010-0000-0000">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">회원가입</button>
    </div>
  </div>
</form>