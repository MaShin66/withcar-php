<?php
    foreach($return_user_value as $data) { ?>
        <div>유저 Id <?=$data->user_id?></div>
        <div>유저 이름 <?=$data->user_name?></div>
        <div>학번 <?=$data->student_id?></div>
        <div>이메일 <?=$data->email?></div>
        <div>휴대폰 번호 <?=$data->phone?></div>
        <div>드라이버 등록 여부 <?=$data->is_driver?></div>
        <div>드라이버 Id <?=$data->driver_id?></div>
        <div>면허 번호 <?=$data->license_number?></div>
        <div>차량 번호 <?=$data->car_number?></div>
        <div>차량 이름 <?=$data->car_name?></div>
        <div>은행 <?=$data->bank?></div>
        <div>예금주 <?=$data->account_holder?></div>
        <div>계좌번호 <?=$data->account?></div>
        <div>회원가입 날짜 <?=$data->created?></div>
        <div>드라이버 등록 날짜 <?=$data->driver_created?></div>
        <br><br>
    <?php
    }
?>