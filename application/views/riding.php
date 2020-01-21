<style>
.div_style {
    border: 1px solid black;
    margin: 20px;
    padding: 20px;
    font-size: 2.8rem;
    border-radius: 16px;
}

.cancel_style {
    text-align: center;
}
</style>

<div class="div_style">
<?php
    if($this->session->userdata('is_driver') === '1') { ?>
        <div>내가 수락한<br>탑승자의 운행 정보</div>
    <?php
    } else if($this->session->userdata('is_driver') === '0') { ?>
        <div>내가 신청한<br>운행 정보</div>
    <?php
    } 
?>
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
    <div>탑승자 이름 <?=$return_value->user_name?></div>
    <div>탑승자 휴대폰 번호<br><?=$return_value->user_phone?></div>
    <br>
    <div>출발지 <?=$return_value->depature?></div>
    <div>도착지 <?=$return_value->destination?></div>
    <br>
    <div>운행 거리 <?=$return_value->drive_distance?> km</div>
    <div>운행 시간 <?=$return_value->drive_time?> 분</div>
    <div>출발 시간 <?=$return_value->ride_time?></div>
    <br>
    <div>금액 <?=$return_value->withcar_price?> 원</div>
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