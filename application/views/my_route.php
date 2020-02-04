<link rel="stylesheet" type="text/css" href="../../../static/css/table.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<div>
    <div class="head_style">
        <div class="title_style">나의 운행 목록</div>
        <br>
        <div class="div_style">
            <a href=<?=site_url()?>/withcar class="a_style">홈으로</a>
            <span class="span_style"></span>
            <a href=<?=site_url()?>/withcar/calculate/<?=$session_data['user_id']?> class="a_style">정산관리</a>
        </div>
    </div>

    <div class="table_style">
        <?php
            foreach($return_value as $data) { ?>
                <div class="tdata_style">
                    <span><i class="far fa-user icon_style"></i></span>
                    <span class="right_style">
                        <?php
                            if($data->status === 'REQUESTING') {
                                $stats = '요청 대기중';
                            } else if($data->status === 'ACCEPTED') {
                                $stats = '요청 수락됨';
                            } else if($data->status === 'ONROUTE') {
                                $stats = '운행중';
                            } else if($data->status === 'FINISHED') {
                                $stats = '운행 종료';
                            } else if($data->status === 'UNPAID') {
                                $stats = '미결제';
                            }
                        ?>
                        <?=$stats?>
                    </span>
                    
                    <div>
                        <span><i class="fas fa-sign-out-alt icon_style"></i> <?=$data->depature?></span>
                        <span class="right_style">거리 <?=$data->drive_distance;?> km</span>
                    </div>
                    <div>
                        <span><i class="fas fa-sign-in-alt icon_style"></i> <?=$data->destination?></span>
                        <span class="right_style">시간 <?=$data->drive_time;?> 분</span>
                    </div>
                    <br>
                    <div class="center_style">
                        <div>출발 시간 <?=$data->ride_time;?> </div>
                        <div><i class="fas fa-coins icon_style"></i> <?=$data->withcar_price;?> 원</div>
                        <div>결제방법:
                        <?php
                            if($data->payment === 'TRANSFER') {
                                $payment = '계좌이체';
                            } else if($data->payment === 'CASH') {
                                $payment = '현금 결제';
                            } else if($data->payment === 'PAY') {
                                $payment = '페이';
                            }
                        ?>
                        <?=$payment?>
                        </div>
                        <br>
                        <div><a href="../ride/<?=$data->ride_id?>">자세히 보기</a></div>
                        <div>운행 생성 날짜 <?=$data->created;?></div>
                    </div>                    
                    
                </div>
            <?php
            }
        ?>
    </div>
</div>