<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<style>
.form_style {
    border: 1px solid black;
    margin: 16px;
    border-radius: 8px;
    padding: 16px;
    font-size: 2rem;
    margin-top: 20%;
}

.submit_style {
    text-align: center;
    border: 1px solid black;
    border-radius: 6px;
    background-color: lightsteelblue;
}

.input_style {
    width: 124px;
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
    var depature_latitude = <?=$ride_address['depature_latitude']?>;
    var depature_longitude = <?=$ride_address['depature_longitude']?>;
    var destination_latitude = <?=$ride_address['destination_latitude']?>;
    var destination_longitude = <?=$ride_address['destination_longitude']?>;
</script>
<script src="../../static/js/tmap_api.js"></script>

<div id="map_div">
</div>

<div class="form_style">
    <form action="ridelist" method="post">
        <div><i class="fas fa-sign-out-alt icon_style"></i> <input type="text" name="depature" value="<?=$ride_address['depature']?>" readonly></div>
        <input type="hidden" name="depature_latitude" value="<?=$ride_address['depature_latitude']?>">
        <input type="hidden" name="depature_longitude" value="<?=$ride_address['depature_longitude']?>">
        <div><i class="fas fa-sign-in-alt icon_style"></i> <input type="text" name="destination" value="<?=$ride_address['destination']?>" readonly></div>
        <input type="hidden" name="destination_latitude" value="<?=$ride_address['destination_latitude']?>">
        <input type="hidden" name="destination_longitude" value="<?=$ride_address['destination_longitude']?>">
        <br>
        <div>운행 거리 (km) <input type="text" id="drive_distance" class="input_style" name="drive_distance" readonly></div>
        <div>운행 시간 (분)<input type="text" id="drive_time" class="input_style" name="drive_time" readonly></div>
        <br>
        <div>
            <span>결제 방법</span>
            <span>
                <select name="payment" id="payment">
                    <option value="TRANSFER" selected>위드카에게 계좌이체</option>
                    <option value="CASH">드라이버에게 현금 계산</option>
                </select>
            </span>
        </div>
        <div>예상 택시요금 <input type="text" id="taxi_price" class="input_style" name="taxi_price" readonly></div>
        <div>예상 위드카 요금 <input type="text" id="withcar_price" class="input_style" name="withcar_price" readonly></div>
        <div>출발 날짜<input type="text" id="date_value" class="input_style" name="date_value" value="<?=$ride_address['date_value']?>" readonly></div>
        <div>출발 시간<input type="text" id="time_value" class="input_style" name="time_value" value="<?=$ride_address['time_value']?>" readonly></div>
        <br>
        <br>
        <?php
            if(isset($session_data['is_login'])) { ?>
                <input type="hidden" name="user_id", value="<?=$session_data['user_id']?>">
                <input type="hidden" name="user_name", value="<?=$session_data['user_name']?>">
                <input type="hidden" name="user_phone", value="<?=$session_data['phone']?>">
                <div class="submit_style"><input type="submit" value="리스트 등록하기"></div>
            <?php
            } else { ?>
                <div class="submit_style"><a href="login">로그인하고 리스트 등록하기</a></div>
            <?php
            }
        ?>
    </form>
</div>