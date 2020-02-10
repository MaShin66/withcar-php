<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<style>
.title_style {
    text-align: center;
}

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

.icon_style {
    font-size: 2rem;
}

.submit_style {
    text-align: center;
}
</style>

<div class="div_style">
    <div class="title_style">주행 결과</div>
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
        <div><i class="fas fa-sign-out-alt icon_style"></i> <?=$return_value->depature?></div>
        <div><i class="fas fa-sign-in-alt icon_style"></i> <?=$return_value->destination?></div>
        <br>
        <div>운행 거리 <?=$return_value->drive_distance?> km</div>
        <div>운행 시간 <?=$return_value->drive_time?> 분</div>
        <br>
        <div>결제 금액 <?=$return_value->withcar_price?></div>
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

        <div>
        <?php 
            if($return_value->status === 'FINISHED') { ?>
                <br>
                <div class="submit_style">결제완료</div>
            <?php
            }
        ?>
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