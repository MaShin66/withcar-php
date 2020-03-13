<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
<link rel="stylesheet" type="text/css" href=<?=base_url()?>static/css/list.css>

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

#Tmap_Map_7_Tmap_ViewPort {
    z-index: 1;
}
</style>

<script src="https://api2.sktelecom.com/tmap/js?version=1&format=javascript&appKey=da7b106e-e761-42bd-948c-e1dd2a1d66d5"></script>        
<script type="text/javascript">
    var depature_latitude = <?=$return_ride_value->depature_latitude?>;
    var depature_longitude = <?=$return_ride_value->depature_longitude?>;
    var destination_latitude = <?=$return_ride_value->destination_latitude?>;
    var destination_longitude = <?=$return_ride_value->destination_longitude?>;
</script>
<script src="../../../static/js/tmap_api2.js"></script>

<div id="map_div">
</div>

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


    <div class="tdata_style">
        <div class="address_style"><i class="fas fa-sign-out-alt icon_style"></i> <?=$return_ride_value->depature?></div>
        <div class="middle_style">
            <div class="middle_left_style"><?=$return_ride_value->drive_distance;?> km</div>
            <div class="middle_center_style"><i class="fas fa-angle-double-down arrow_style"></i></div>
            <div class="middle_right_style"><?=$return_ride_value->drive_time;?> 분</div>
        </div>
        <div class="address_style"><i class="fas fa-sign-in-alt icon_style"></i> <?=$return_ride_value->destination?></div>
    
        <br>

        <?php
            $time = $return_ride_value->ride_time;
            $time = substr($time, 5);
        ?>

        <div>
            <div class="time_style"><?=$time?></div>
            <div class="price_style"><i class="fas fa-coins icon_style"></i> <?=$return_ride_value->withcar_price?></div>
        </div>
        <div>
            <div class="number_style"><?=$return_ride_value->population_number?> 명</div>
            <div class="pay_style">
                <?php
                    if($return_ride_value->payment === 'TRANSFER') {
                        $payment = '계좌이체';
                    } else if($return_ride_value->payment === 'CASH') {
                        $payment = '현금 결제';
                    } else if($return_ride_value->payment === 'PAY') {
                        $payment = '페이 결제';
                    }
                ?>
                <?=$payment?>
            </div>
        </div>
    </div>

    <br>
    <br>

    <?php
    $session_data = $this->session->userdata();
        if($session_data['is_driving'] === '1' && $return_ride_value->status === 'REQUESTING') { ?>
            <div class="cancel_style"><a href="../riding/<?=$return_ride_value->ride_id?>">운행 예약하기</a></div>
        <?php
        } else if($session_data['is_driving'] === '0' 
            && ($session_data['user_id'] === $return_ride_value->user_id)
            && ($return_ride_value->status === 'REQUESTING'
            || $return_ride_value->status === 'ACCEPTED' 
            || $return_ride_value->status === 'ONROUTE')) { 
                if($return_ride_value->status === 'ACCEPTED') { ?>
                    <div class="cancel_style"><a href="../chat/<?=$return_ride_value->ride_id?>">채팅하기</a></div>
                    <br>
                <?php
                } ?>
            <div class="cancel_style"><a href="../ride_cancel/<?=$return_ride_value->ride_id?>">운행 취소</a></div>
        <?php
        }
    ?>
    
</div>