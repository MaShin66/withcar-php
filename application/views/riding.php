내가 신청한 탑승자의 운행 정보

<?php var_dump($return_value); ?>



<?php
    if($return_value[0]->status === 'ACCEPTED'){ ?>
        <a href="../ride_cancel/<?=$return_value[0]->ride_id?>">운행 취소</a>
        <br><br>
        <a href="../onroute/<?=$return_value[0]->ride_id?>">탑승자를 태웠다면 클릭해주세요</a>
    <?php
    } else if($return_value[0]->status === 'ONROUTE'){ ?>
        <h1>운행중입니다..</h1>
        <a href="../finished/<?=$return_value[0]->ride_id?>">운행 종료</a>
    <?php
    }
?>