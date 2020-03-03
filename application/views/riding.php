<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<style>
.div_style {
    border: 1px solid black;
    margin: 20px;
    padding: 20px;
    font-size: 2.2rem;
    border-radius: 16px;
}

.cancel_style {
    text-align: center;
}

.icon_style {
    font-size: 3rem;
}

.title_style {
    text-align: center;
    font-size: 3.6rem;
}

.subtitle_style {
    text-align: center;
}
</style>

<div class="div_style">
    <div class="title_style">
        <?php
            if($return_value->status === 'REQUESTING') {
                $stats = '요청 대기중';
            } else if($return_value->status === 'ACCEPTED') {
                $stats = '운행 대기중';
            } else if($return_value->status === 'ONROUTE') {
                $stats = '운행중';
            } else if($return_value->status === 'FINISHE') {
                $stats = '운행 종료';
            } else if($return_value->status === 'UNPAID') {
                $stats = '미결제';
            }
        ?>
        <?=$stats?>
        <br>
        <div id="clock"></div>
    </div>
    <br>
    <div class="subtitle_style">
        <?php
            if($this->session->userdata('is_driver') === '1') { ?>
                <div>탑승자 운행 정보</div>
                <br>
                <div><i class="far fa-user icon_style"></i> <?=$return_value->user_name?></div>
                <div><i class="fas fa-mobile-alt icon_style"></i> <a href="tel: <?=$return_value->user_phone?>"><?=$return_value->user_phone?></a></div>
                <br>
            <?php
            } else if($this->session->userdata('is_driver') === '0') { ?>
                <div>운전자 운행 정보</div>
                <br>
                <div><i class="far fa-user icon_style"></i> <?=$return_value->driver_name?></div>
                <div><i class="fas fa-mobile-alt icon_style"></i> <a href="tel: <?=$return_value->driver_phone?>"><?=$return_value->driver_phone?></a></div>
                <br>
            <?php
            } 
        ?>
    </div>
    <div><i class="fas fa-sign-out-alt icon_style"></i> <?=$return_value->depature?></div>
    <div><i class="fas fa-sign-in-alt icon_style"></i> <?=$return_value->destination?></div>
    <br>
    <div>운행 거리 <?=$return_value->drive_distance?> km</div>
    <div>운행 시간 <?=$return_value->drive_time?> 분</div>
    <div id="ride_time">출발 시간 <?=$return_value->ride_time?> 분</div>
    <div>탑승 인원 <?=$return_value->population_number?> 명</div>
    <br>
    <div><i class="fas fa-coins icon_style"></i> <?=$return_value->withcar_price?></div>
    <br>

<?php
    if($return_value->status === 'ACCEPTED') { ?>
        <div class="cancel_style"><a href="../ride_cancel/<?=$return_value->ride_id?>">운행 취소</a></div>
        <br>
        <div class="cancel_style"><a href="../onroute/<?=$return_value->ride_id?>">탑승자를 태웠다면<br>클릭해주세요</a></div>
    <?php
    } else if($return_value->status === 'ONROUTE') { ?>
        <h1>운행중입니다..</h1>
        <a href="../finished/<?=$return_value->ride_id?>">운행 종료</a>
    <?php
    } else if($return_value->status === 'UNPAID') {
        redirect('withcar/finished/'.$return_value->ride_id, 'refresh');
    }
?>

</div>

<script>
    function clock_function() {
        var ride_time = document.getElementById("ride_time").innerText;
        var ride_time = new Date(ride_time.substring(6, 22));
        
        var currentDate = new Date();

        var diff = ride_time - currentDate;
        
        if(diff < 0) break;

        var standard_second = 1000
        , standard_minute = standard_second * 60
        , standard_hour = standard_minute * 60
        , standard_day = standard_hour * 24
        , standard_month = standard_day * 30
        , standard_year = standard_month * 12;

        var diff_minute = parseInt(diff/standard_minute) % 60
        , diff_hour = parseInt(diff/standard_hour) % 24
        , diff_day = parseInt(diff/standard_day) % 30
        , diff_month = parseInt(diff/standard_month) % 12
        , diff_year = parseInt(diff/standard_year);

        document.getElementById("clock").innerHTML = '';

        document.getElementById("clock").innerHTML += '출발까지 남은 시간 <br>';
        if(diff_year >= 1) {
            document.getElementById("clock").innerHTML += diff_year + ' 년 ';    
        }
        if(diff_month >= 1) {
            document.getElementById("clock").innerHTML += diff_month + ' 달 ';    
        }
        document.getElementById("clock").innerHTML += diff_day + ' 일 ' + diff_hour + ' 시간 ' + diff_minute + ' 분';
    }
    
    clock_function();
    setInterval('clock_function()', 1000 * 60);
</script>