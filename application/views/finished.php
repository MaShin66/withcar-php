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
        <div>운행 거리 <?=$return_value->drive_distance?></div>
        <div>운행 시간 <?=$return_value->drive_time?></div>
        <br>
        <div>결제 금액 <?=$return_value->withcar_price?></div>
        <div>결제 방법 <?=$return_value->payment?></div>
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