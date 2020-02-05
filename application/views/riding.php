<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<style>
.div_style {
    border: 1px solid black;
    margin: 20px;
    padding: 20px;
    font-size: 2.2rem;
    border-radius: 16px;
}

.cancel_style {
    text-align: center;
}

.icon_style {
    font-size: 3rem;
}

.title_style {
    text-align: center;
}
</style>

<div class="div_style">
    <div class="title_style">
        <?php
            if($this->session->userdata('is_driver') === '1') { ?>
                <div>내가 수락한<br>탑승자의 운행 정보</div>
            <?php
            } else if($this->session->userdata('is_driver') === '0') { ?>
                <div>내가 신청한<br>운행 정보</div>
            <?php
            } 
        ?>
    </div>

    <br>
    <div>
        <?php
            if($return_value->status === 'REQUESTING') {
                $stats = '요청 대기중';
            } else if($return_value->status === 'ACCEPTED') {
                $stats = '요청 수락됨';
            } else if($return_value->status === 'ONROUTE') {
                $stats = '운행중';
            } else if($return_value->status === 'FINISHE') {
                $stats = '운행 종료';
            } else if($return_value->status === 'UNPAID') {
                $stats = '미결제';
            }
        ?>
        <?=$stats?>
    </div>
    <div><i class="far fa-user icon_style"></i> <?=$return_value->user_name?></div>
    <div><i class="fas fa-mobile-alt icon_style"></i> <?=$return_value->user_phone?></div>
    <br>
    <div><i class="fas fa-sign-out-alt icon_style"></i> <?=$return_value->depature?></div>
    <div><i class="fas fa-sign-in-alt icon_style"></i> <?=$return_value->destination?></div>
    <br>
    <div>운행 거리 <?=$return_value->drive_distance?> km</div>
    <div>운행 시간 <?=$return_value->drive_time?> 분</div>
    <div>출발 시간 <?=$return_value->ride_time?> 분</div>
    <br>
    <div><i class="fas fa-coins icon_style"></i>
        <?php $price = $return_value->withcar_price;
        echo substr($price, 0, -3).','.substr($price, -3).' 원';?>
    </div>
    <br>

<?php
    if($return_value->status === 'ACCEPTED') { ?>
        <div class="cancel_style"><a href="../ride_cancel/<?=$return_value->ride_id?>">운행 취소</a></div>
        <br>
        <div class="cancel_style"><a href="../onroute/<?=$return_value->ride_id?>">탑승자를 태웠다면<br>클릭해주세요</a></div>
    <?php
    } else if($return_value->status === 'ONROUTE') { ?>
        <h1>운행중입니다..</h1>
        <a href="../finished/<?=$return_value->ride_id?>">운행 종료</a>
    <?php
    } else if($return_value->status === 'UNPAID') {
        redirect('withcar/finished/'.$return_value->ride_id, 'refresh');
    }
?>

</div>