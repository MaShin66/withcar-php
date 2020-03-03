<link rel="stylesheet" type="text/css" href=<?=base_url()?>static/css/table.css>
<link rel="stylesheet" type="text/css" href=<?=base_url()?>static/css/list.css>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<div>
    <div class="head_style">
        <?php
            if(strstr(current_url(),'requested_ride') && $session_data['is_driving'] === '1') { ?>
                <div class="title_style">탑승 승인한 운행</div>
            <?php
            } else if(strstr(current_url(),'requested_ride') && $session_data['is_driving'] === '0') { ?>
                <div class="title_style">탑승 수락된 운행</div>
            <?php
            } else if($session_data['is_driving'] === '1') { ?>
                <div class="title_style">대기중인 운행</div>
            <?php
            } else if($session_data['is_driving'] === '0') { ?>
                <div class="title_style">등록한 운행</div>
            <?php
            }
        ?>
        <br>
        <div class="div_style">
            <?php
                if($this->session->userdata('is_driving') === '0') { ?>
                    <a href="../withcar" class="a_style">홈으로</a>
                <?php
                }
            ?>            
            <span class="span_style"></span>
            <a href=<?=current_url()?> class="a_style">새로고침</a>
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
                        <div>
                            <div class="number_style"><?=$data->population_number?> 명</div>
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
                        </div>
                        <div class="click_style">
                        <?php
                            if(strstr(current_url(),'requested_ride') && $this->session->userdata('is_driving') === '1') { ?>
                                <a href=<?=site_url()?>/withcar/riding/<?=$data->ride_id?>>자세히 보기</a>    
                            <?php
                            } else { ?>
                                <a href=<?=site_url()?>/withcar/ride/<?=$data->ride_id?>>자세히 보기</a>
                            <?php
                            }
                        ?>
                        </div>


                </div>
            <?php
            }
        ?>
    </div>
</div>