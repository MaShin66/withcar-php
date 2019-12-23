<?php
    foreach($return_ridelist as $data) { ?>
        <div><?=$data->user_name?></div>
        <div><?=$data->status?></div>
        <a href="ride/<?=$data->ride_id?>">자세히 보기</a>
        <br><br>
    <?php
    }
?>