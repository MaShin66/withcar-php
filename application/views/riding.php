내가 신청한 탑승자의 운행 정보

<div>상태 <?=$return_value->status?></div>
<div>탑승자 이름 <?=$return_value->user_name?></div>
<div>출발지 <?=$return_value->depature?></div>
<div>도착지 <?=$return_value->destination?></div>
<div>운행 거리 <?=$return_value->drive_distance?></div>
<div>운행 시간 <?=$return_value->drive_time?></div>
<div>출발 시간 <?=$return_value->ride_time?></div>
<div>금액 <?=$return_value->withcar_price?></div>
<br><br>
<div>운전자 Id <?=$return_value->driver_id?></div>
<div>운전자 이름 <?=$return_value->driver_name?></div>
<div>결제방식 <?=$return_value->payment?></div>



<?php
    if($return_value->status === 'ACCEPTED') { ?>
        <a href="../ride_cancel/<?=$return_value->ride_id?>">운행 취소</a>
        <br><br>
        <a href="../onroute/<?=$return_value->ride_id?>">탑승자를 태웠다면 클릭해주세요</a>
    <?php
    } else if($return_value->status === 'ONROUTE') { ?>
        <h1>운행중입니다..</h1>
        <a href="../finished/<?=$return_value->ride_id?>">운행 종료</a>
    <?php
    } else if($return_value->status === 'UNPAID') {
        redirect('withcar/finished/'.$return_value->ride_id, 'refresh');
    }
?>