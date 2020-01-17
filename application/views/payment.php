<style>
.div_style {
    border: 1px solid black;
    margin: 20px;
    padding: 20px;
    font-size: 2.8rem;
    border-radius: 16px;
    margin-top: 100px;
}

.cancel_style {
    text-align: center;
}
</style>

<div class="div_style">
    <?php
        if($return_ride_value->payment === 'TRANSFER') { ?>
            <div>결제금액을<br>계좌이체 해주세요.</div>
            <br>
            <div>계좌정보</div>
            <div>은행: <?=$return_user_value->bank?></div>
            <div>계좌번호: <?=$return_user_value->account?></div>
            <div>예금주: </div>
            <div>금액: <?=$return_ride_value->withcar_price?> 원</div>
        <?php
        }
    ?>
    <br>
    <div class="cancel_style"><a href="../is_pay/<?=$return_ride_value->ride_id?>">이체완료</a></div>
</div>