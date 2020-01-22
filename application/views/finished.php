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
    <div>주행 결과</div>
    <?php
        if($return_value->status === 'UNPAID') { ?>
            <div>미결제</div>
        <?php
        }
    ?>
    <br>
    <?php
        if($this->session->userdata('is_driver') === '1') { ?>
            <div>드라이버</div>
        <?php
        } else if($this->session->userdata('is_driver') === '0') { ?> 
            <div>탑승자</div>
        <?php
        }
    ?>

    <div>
        <div>탑승자 <?=$return_value->user_name?></div>
        <div>운전자 <?=$return_value->driver_name?></div>
        <br>
        <div>출발지 <?=$return_value->depature?></div>
        <div>도착지 <?=$return_value->destination?></div>
        <br>
        <div>운행 거리 <?=$return_value->drive_distance?> km</div>
        <div>운행 시간 <?=$return_value->drive_time?> 분</div>
        <br>
        <div>결제 금액 <?=$return_value->withcar_price?> 원</div>
        <div>결제방법
            <?php
            if($return_value->payment === 'TRANSFER') {
                $payment = '계좌이체';
            } else if($return_value->payment === 'CASH') {
                $payment = '현금 결제';
            } else if($return_value->payment === 'PAY') {
                $payment = '페이';
            }
            ?>
            <?=$payment?>
        </div>
    </div>

    <?php
        if($this->session->userdata('is_driver') === '1') { ?>
        <?php
        } else if($this->session->userdata('is_driver') === '0') { ?> 
            <br>
            <div class="cancel_style"><a href="../payment/<?=$return_value->ride_id?>">결제하기</a></div>
        <?php
        }
    ?>
</div>