<?php
    // var_dump($return_ride_value);
    // var_dump($return_user_value);
?>

<?php
    if($return_ride_value->payment === 'TRANSFER') { ?>
        <div>결제금액을 계좌이체 해주세요.</div>
        <div>계좌정보</div>
        <div>은행: <?=$return_user_value->bank?></div>
        <div>계좌번호: <?=$return_user_value->account?></div>
        <div>예금주: </div>
        <div>금액: <?=$return_ride_value->withcar_price?></div>
    <?php
    }
?>

<a href="../is_pay/<?=$return_ride_value->ride_id?>">이체완료</a>