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

.title_div {
    height: 50px;
    text-align: center;
}

.status_style {
    text-align: center;
}

.icon_style {
    font-size: 2rem;
}
</style>

<div class="div_style">
    <div class="title_div">정산 내역</div>
    <br>
    <div>미결제 금액</div>
    <?php
        $price = $return_unpiad_price->withcar_price;
        echo substr($price, 0, -3).','.substr($price, -3).' 원';
    ?>
    <br><br>
    <div>미정산 금액</div>
    <?php
        
    ?>
    <br>
    <div>누적 정산 금액</div>
    <?php
        $price = $return_finished_price->withcar_price;
        echo substr($price, 0, -3).','.substr($price, -3).' 원';
    ?>
</div>