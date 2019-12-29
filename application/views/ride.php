<?php
    if($this->session->userdata('is_driver') === '1') {
        echo '드라이버 모드';
    } else {
        echo '이용자 모드';
    }
?>

<?=$return_ride_value[0]->ride_id?>
<br>
<?=$return_ride_value[0]->status?>
<br>
<?=$return_ride_value[0]->user_name?>
<br>
<?=$return_ride_value[0]->depature?>
<br>
<?=$return_ride_value[0]->destination?>
<br>
<?=$return_ride_value[0]->drive_distance?>
<br>
<?=$return_ride_value[0]->drive_time?>
<br>
<?=$return_ride_value[0]->withcar_price?>

<?php
    if($this->session->userdata('is_driver') === '1') { ?>
        <a href="../riding/<?=$return_ride_value[0]->ride_id?>">탑승 시키기</a>
    <?php
    }
?>