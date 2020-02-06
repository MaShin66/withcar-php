<style>
.form-horizontal {
    left: 10%;
    top: 32%;
    position: absolute;
    width: 80%;
}

.submit_style {
    text-align: right;
}

.title {
    text-align: center;
    font-size: 2rem;
}
</style>


<form class="form-horizontal" action="../edit_account2" method="post">
<div class="title">계좌 정보</div>
<div class="form-group">
    <label for="bank" class="col-sm-2 control-label">은행</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="bank" name="bank" value="<?=$return_user_value->bank?>">
    </div>
</div>

<div class="form-group">
    <label for="account_holder" class="col-sm-2 control-label">은행</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="account_holder" name="account_holder" value="<?=$return_user_value->account_holder?>">
    </div>
</div>

<div class="form-group">
    <label for="account" class="col-sm-2 control-label">은행</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="account" name="account" value="<?=$return_user_value->account?>">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 submit_style">
    <button type="submit" class="btn btn-default">변경하기</button>
</div>

</form>