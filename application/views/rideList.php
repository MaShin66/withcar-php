<h1>전체 운행 목록</h1>
<a href="../withcar">홈으로</a>
<br><br>
<a href="./ridelist">새로고침</a>
<br><br>

<?php
    foreach($return_ridelist as $data) { ?>
        <div>탑승자<?=$data->user_name?></div>
        <div><?=$data->status?></div>
        <div>출발지<?=$data->depature?></div>
        <div>도착지<?=$data->destination?></div>
        <div>거리<?=$data->drive_distance;?></div>
        <div>시간<?=$data->drive_time;?></div>
        <div>금액<?=$data->withcar_price;?></div>
        <div>금액<?=$data->payment;?></div>
        <a href="ride/<?=$data->ride_id?>">자세히 보기</a>
        <br><br>
    <?php
    }
?>