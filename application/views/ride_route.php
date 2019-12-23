<script src="https://api2.sktelecom.com/tmap/js?version=1&format=javascript&appKey=da7b106e-e761-42bd-948c-e1dd2a1d66d5"></script>        
<script type="text/javascript">
    var depature_latitude = <?=$ride_address['depature_latitude']?>;
    var depature_longitude = <?=$ride_address['depature_longitude']?>;
    var destination_latitude = <?=$ride_address['destination_latitude']?>;
    var destination_longitude = <?=$ride_address['destination_longitude']?>;
</script>

<body onload="initTmap()">

    <a href=".">홈으로</a>

    <div id="map_div">
    </div>
    <p id="result">결과 표시</p>
    <form action="ridelist" method="post">
        
        <input type="text" name="depature" value="<?=$ride_address['depature']?>">
        <input type="text" name="depature_latitude" value="<?=$ride_address['depature_latitude']?>">
        <input type="text" name="depature_longitude" value="<?=$ride_address['depature_longitude']?>">

        <input type="text" name="destination" value="<?=$ride_address['destination']?>">
        <input type="text" name="destination_latitude" value="<?=$ride_address['destination_latitude']?>">
        <input type="text" name="destination_longitude" value="<?=$ride_address['destination_longitude']?>">
        
        <input type="text" id="drive_distance" name="drive_distance">
        <input type="text" id="drive_time" name="drive_time">
        <div>예상 택시요금 <input type="text" id="taxi_price" name="taxi_price"></div>
        <div>예상 위드카 요금 <input type="text" id="withcar_price" name="withcar_price"></div>

        <?php
            if(isset($session_data['is_login'])) { ?>
                <input type="text" name="user_id", value="<?=$session_data['user_id']?>">
                <input type="text" name="user_name", value="<?=$session_data['user_name']?>">
                <input type="submit" value="리스트 등록하기">
            <?php
            } else { ?>
                <a href="login">로그인하고 리스트 등록하기</a>
            <?php
            }
        ?>
        
    </form>


<script src="../../static/js/tmap_api.js"></script>