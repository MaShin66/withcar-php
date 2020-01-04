<style>
.form-horizontal {
  left: 10%;
  top: 38%;
  position: absolute;
  width: 80%;
}
</style>

<form class="form-horizontal" action="authentication" method="post">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">이메일주소</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="abc@gmail.com">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">비밀번호</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" name="password" placeholder="비밀번호">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">로그인</button>
    </div>
  </div>
</form>