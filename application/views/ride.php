<?php
    if($this->session->userdata('is_driver') === '1') {
        echo '드라이버 모드';
    } else {
        echo '이용자 모드';
    }

    if($return_ride_value->status === 'ACCEPTED'){
        echo '이용자 모드';
        echo '<script>alert("드라이버가 요청을 수락했습니다.");</script>';
    } else if($return_ride_value->status === 'ONROUTE') {
        echo '<script>alert("드라이버가 운행을 시작했습니다. 운행정보 페이지로 이동합니다.");</script>';
        redirect('withcar/onroute/'.$return_ride_value->ride_id, 'refresh');
    }

?>

<?=$return_ride_value->ride_id?>
<br>
<?=$return_ride_value->status?>
<br>
<?=$return_ride_value->user_name?>
<br>
<?=$return_ride_value->depature?>
<br>
<?=$return_ride_value->destination?>
<br>
<?=$return_ride_value->drive_distance?>
<br>
<?=$return_ride_value->drive_time?>
<br>
<?=$return_ride_value->withcar_price?>
<br>
<?=$return_ride_value->payment?>

<br><br>
<a href="../ride_cancel/<?=$return_ride_value->ride_id?>">운행 취소</a>

<?php
    if($this->session->userdata('is_driver') === '1') { ?>
        <a href="../riding/<?=$return_ride_value->ride_id?>">탑승 시키기</a>
    <?php
    }
?>