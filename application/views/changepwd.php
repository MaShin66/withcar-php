<style>
.form-horizontal {
    left: 10%;
    top: 40%;
    position: absolute;
    width: 80%;
}

.submit_style {
    text-align: right;
}
</style>

<form class="form-horizontal" action="../chagepwd2" method="post">
<div class="form-group">
    <label for="password" class="col-sm-2 control-label">바꿀 비밀번호</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" name="password">
    </div>
  </div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 submit_style">
    <button type="submit" class="btn btn-default">비밀번호 변경</button>
    </div>
</div>
</form>