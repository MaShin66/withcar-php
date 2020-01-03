<h1>주행결과</h1>

<!-- <?php var_dump($return_value); ?> -->
<!-- <?php var_dump($this->session->userdata); ?> -->

<?php

    if($this->session->userdata('is_driver') === '1') { ?>
        <h1>드라이버</h1>
        <div>탑승자 <?=$return_value->user_name?></div>
        <div>운전자 <?=$return_value->driver_name?></div>

        <div>출발지 <?=$return_value->depature?></div>
        <div>도착지 <?=$return_value->destination?></div>

        <div>운행 거리 <?=$return_value->drive_distance?></div>
        <div>운행 시간 <?=$return_value->drive_time?></div>

        <div>결제 금액 <?=$return_value->withcar_price?></div>
        <div>결제 방법 <?=$return_value->payment?></div>
        
        <br>

    <?php
    } else { ?> 
        <h1>탑승자</h1>
        <div>탑승자 <?=$return_value->user_name?></div>
        <div>운전자 <?=$return_value->driver_name?></div>

        <div>출발지 <?=$return_value->depature?></div>
        <div>도착지 <?=$return_value->destination?></div>

        <div>운행 거리 <?=$return_value->drive_distance?></div>
        <div>운행 시간 <?=$return_value->drive_time?></div>

        <div>결제 금액 <?=$return_value->withcar_price?></div>
        <div>결제 방법 <?=$return_value->payment?></div>
        
        <br>
        <a href="../payment/<?=$return_value->ride_id?>">결제하기</a>
    <?php
    }

?>

<br><br>
<a href="../../withcar">홈으로</a>