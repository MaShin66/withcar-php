<style>
.div_style {
    margin-top: 80px;
    padding-left: 29px;
    font-size: 2.3rem;
}
</style>

<div class="div_style">
    <div>내 정보</div>
    <br>
    <div>이름 <?=$return_user_value->user_name?></div>
    <div>학번(교번) <?=$return_user_value->student_id?></div>
    <div>이메일 주소 <?=$return_user_value->email?></div>
    <div>휴대폰 번호 <?=$return_user_value->phone?></div>
    <div><a href="../changepwd/<?=$return_user_value->user_id?>">비밀번호 변경</a></div>
    <br>
<?php
    if($return_user_value->is_driver === '0') { ?>
        <div>운전자 등록을 하지 않았습니다</div>
    <?php
    } else if($return_user_value->is_driver === '1') { ?>
        <div>운전자 정보</div>
        <div>면허 번호 <?=$return_user_value->license_number?></div>
        <div>차 이름 <?=$return_user_value->car_name?></div>
        <div>차 번호 <?=$return_user_value->car_number?></div>
        <br>
        <div>계좌 정보</div>
        <div>은행 <?=$return_user_value->bank?></div>
        <div>예금주 <?=$return_user_value->account_holder?></div>
        <div>계좌번호 <?=$return_user_value->account?></div>
    <?php
    }
?>
</div>