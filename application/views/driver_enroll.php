<style>
.form-horizontal {
    left: 10%;
    top: 22%;
    position: absolute;
    width: 80%;
}

.title_style {
    text-align: center;
    font-size: 3rem;
}

.h1_style {
    font-size: 2rem;
}
</style>

<div class="title_style">드라이버 등록</div>
<form class="form-horizontal" action="../driver_enroll2/<?=$user_id?>" method="post">
    <input type="hidden" name="is_driver" value=1>
  <div class="form-group">
    <label for="license_number" class="col-sm-2 control-label">자동차 운전면허증 번호</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="license_number" name="license_number">
    </div>
  </div>
  <div class="form-group">
    <label for="car_number" class="col-sm-2 control-label">차량 번호</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="car_number" name="car_number" placeholder="11가1111">
    </div>
  </div>
  <div class="form-group">
    <label for="car_name" class="col-sm-2 control-label">차종</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="car_name" name="car_name" placeholder="소나타">
    </div>
  </div>
  <br>
  <div class="h1_style">이체받을 계좌번호 입력</div>
  <br>
  <div class="form-group">
    <label for="bank" class="col-sm-2 control-label">은행</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="bank" name="bank">
    </div>
  </div>
  <div class="form-group">
    <label for="account_holder" class="col-sm-2 control-label">예금주</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="account_holder" name="account_holder">
    </div>
  </div>
  <div class="form-group">
    <label for="account" class="col-sm-2 control-label">계좌번호</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="account" name="account">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10" style="text-align: center;">
      <button type="submit" class="btn btn-default">드라이버 등록 완료</button>
    </div>
  </div>
</form>