<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<style>
.div_style {
    margin-top: 80px;
    padding-left: 29px;
    font-size: 2.3rem;
    border: 1px solid black;
    padding: 20px;
    border-radius: 14px;
    margin: 18px;
    margin-top: 40%;
    line-height: 38px;
}

.my_style {
    font-size: 3rem;
    text-align: center;
}
</style>

<div class="div_style">
    <div class="my_style">내 정보</div>
    <br>
    <div>이름 <?=$return_user_value->user_name?></div>
    <div>학번(교번) <?=$return_user_value->student_id?></div>
    <div>이메일 주소 <?=$return_user_value->email?></div>
    <div>휴대폰 번호 <a href="tel: <?=$return_user_value->phone?>"><?=$return_user_value->phone?></a></div>
    <div><a href="../changepwd/<?=$return_user_value->user_id?>">비밀번호 변경</a></div>
    <br>
<?php
    if($return_user_value->is_driver === '0') { ?>
        <div><a href=<?=site_url()?>/withcar/driver_enroll/<?=$session_data['user_id']?>>운전자 등록</a></div>
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
        <div><a href="../edit_account/<?=$return_user_value->user_id?>">계좌 정보 변경하기</a></div>
    <?php
    }
?>
</div>