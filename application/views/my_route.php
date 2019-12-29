<a href="../../withcar">홈으로</a>

<h1>내가 운행한 / 등록한 경로 보기</h1>

<?php
    foreach($return_value as $data) { ?>
        <div><?=$data->status;?></div>
        <div><?=$data->depature;?></div>
        <div><?=$data->destination;?></div>
        <div><?=$data->drive_distance;?></div>
        <div><?=$data->drive_time;?></div>
        <div><?=$data->withcar_price;?></div>
        <div><?=$data->created;?></div>
        <br>
    <?php
    }
?>

