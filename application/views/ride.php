<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

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

.height_div {
    height: 50px;
}

.status_style {
    text-align: center;
}

.icon_style {
    font-size: 2rem;
}
</style>

<?php
    if($return_ride_value->status === 'ACCEPTED'){
        // echo '이용자 모드';
        echo '<script>alert("드라이버가 요청을 수락했습니다.");</script>';
    } else if($return_ride_value->status === 'ONROUTE') {
        echo '<script>alert("드라이버가 운행을 시작했습니다. 운행정보 페이지로 이동합니다.");</script>';
        redirect('withcar/onroute/'.$return_ride_value->ride_id, 'refresh');
    }
?>
<div class="height_div"></div>
<div class="div_style">
    <div class="status_style">
        <?php
            if($return_ride_value->status === 'REQUESTING') {
                $stats = '요청 대기중';
            } else if($return_ride_value->status === 'ACCEPTED') {
                $stats = '요청 수락됨';
            } else if($return_ride_value->status === 'ONROUTE') {
                $stats = '운행중';
            } else if($return_ride_value->status === 'FINISHED') {
                $stats = '운행 종료';
            } else if($return_ride_value->status === 'UNPAID') {
                $stats = '미결제';
            }
        ?>
        <?=$stats?>
    </div>
    <br>
    <div><i class="far fa-user icon_style"></i> <?=$return_ride_value->user_name?></div>
    <div><i class="fas fa-sign-out-alt icon_style"></i> <?=$return_ride_value->depature?></div>
    <div><i class="fas fa-sign-in-alt icon_style"></i> <?=$return_ride_value->destination?></div>
    <div>운행 거리 <?=$return_ride_value->drive_distance?> km</div>
    <div>운행 시간 <?=$return_ride_value->drive_time?> 분</div>
    <div><i class="fas fa-coins icon_style"></i> <?=$return_ride_value->withcar_price?></div>
    <div>결제방법
    <?php
        if($return_ride_value->payment === 'TRANSFER') {
            $payment = '계좌이체';
        } else if($return_ride_value->payment === 'CASH') {
            $payment = '현금 결제';
        } else if($return_ride_value->payment === 'PAY') {
            $payment = '페이';
        }
    ?>
    <?=$payment?>
    </div>
    <br><br>
    <?php
        if($this->session->userdata('is_driver') === '1' && $return_ride_value->status === 'REQUESTING') { ?>
            <div class="cancel_style"><a href="../riding/<?=$return_ride_value->ride_id?>">탑승 시키기</a></div>
        <?php
        } else if($this->session->userdata('is_driver') === '0' 
            && ($this->session->userdata('user_id') === $return_ride_value->user_id)
            && ($return_ride_value->status === 'REQUESTING' 
            || $return_ride_value->status === 'ACCEPTED' 
            || $return_ride_value->status === 'ONROUTE')) { ?>
            <div class="cancel_style"><a href="../ride_cancel/<?=$return_ride_value->ride_id?>">운행 취소</a></div>
        <?php
        }
    ?>
    
</div>