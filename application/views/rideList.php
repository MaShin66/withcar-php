<link rel="stylesheet" type="text/css" href="../../static/css/table.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<style>
.address_style {
    text-align: center;
}

.middle_style {
    display: flex;
    margin: 4% 0;
}

.middle_left_style {
    flex: 1;
    text-align: right;
    margin: auto;
}

.middle_center_style {
    flex: 1;
    text-align: center;
    margin: auto;
}

.middle_right_style {
    flex: 1;
    text-align: left;
    margin: auto;
}

.arrow_style {
    font-size: 4rem;
}

.time_style {
    display: inline-block;
}

.price_style {
    display: inline-block;
    float: right;
}

.pay_style {
    float: right;
}

.click_style {
    /* text-align: center; */
}
</style>

<script>
    // price = '1,234,567,890';
    price = '1234567890';
    console.log(price);
    for(var i in price) {
        var price2 = price.substr(-4*i, 1)+',';
        console.log(price2);
    }
</script>

<div>
    <div class="head_style">
        <div class="title_style">대기중인 운행</div>
        <br>
        <div class="div_style">
            <a href="../withcar" class="a_style">홈으로</a>
            <span class="span_style"></span>
            <a href="./ridelist" class="a_style">새로고침</a>
        </div>
    </div>
    <div class="table_style">
        <?php
            foreach($return_ridelist as $data) { ?>
                <div class="tdata_style">
                        <div class="address_style"><i class="fas fa-sign-out-alt icon_style"></i> <?=$data->depature?></div>
                        <div class="middle_style">
                            <div class="middle_left_style"><?=$data->drive_distance;?> km</div>
                            <div class="middle_center_style"><i class="fas fa-angle-double-down arrow_style"></i></div>
                            <div class="middle_right_style"><?=$data->drive_time;?> 분</div>
                        </div>
                        <div class="address_style"><i class="fas fa-sign-in-alt icon_style"></i> <?=$data->destination?></div>
                    
                        <br>

                        <?php
                            $time = $data->ride_time;
                            $time = substr($time, 5);
                        ?>

                        <div>
                            <div class="time_style"><?=$time?></div>
                            <div class="price_style"><i class="fas fa-coins icon_style"></i> <?=$data->withcar_price?></div>
                        </div>
                        
                        <div class="pay_style">
                            <?php
                                if($data->payment === 'TRANSFER') {
                                    $payment = '계좌이체';
                                } else if($data->payment === 'CASH') {
                                    $payment = '현금 결제';
                                } else if($data->payment === 'PAY') {
                                    $payment = '페이 결제';
                                }
                            ?>
                            <?=$payment?>
                        </div>
                        
                        <div class="click_style">
                            <a href="ride/<?=$data->ride_id?>">자세히 보기</a>
                        </div>


                </div>
            <?php
            }
        ?>
    </div>
</div>