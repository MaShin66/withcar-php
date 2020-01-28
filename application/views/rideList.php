<link rel="stylesheet" type="text/css" href="../../static/css/table.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />

<style>
.icon_style {
    font-size: 2rem;
}
</style>

<div>
    <div class="head_style">
        <div class="title_style">전체 운행 목록</div>
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
                    <div>
                        <span><i class="far fa-user icon_style"></i> <?=$data->user_name?></span>
                        <span class="status_style">
                            <?php
                                if($data->status === 'REQUESTING') {
                                    $stats = '요청 대기중';
                                } else if($data->status === 'ACCEPTED') {
                                    $stats = '요청 수락됨';
                                } else if($data->status === 'ONROUTE') {
                                    $stats = '운행중';
                                } else if($data->status === 'FINISHE') {
                                    $stats = '운행 종료';
                                } else if($data->status === 'UNPAID') {
                                    $stats = '미결제';
                                }
                            ?>
                            <?=$stats?>
                        </span>
                    </div>
                    <div><i class="fas fa-sign-in-alt icon_style"></i> <?=$data->depature?></div>
                    <div><i class="fas fa-sign-out-alt icon_style"></i> <?=$data->destination?></div>
                    <div>거리 <?=$data->drive_distance;?> km</div>
                    <div>시간 <?=$data->drive_time;?> 분</div>
                    <div><i class="fas fa-coins icon_style"></i> <?=$data->withcar_price;?> 원</div>
                    <div>결제방법
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
                    <div><a href="ride/<?=$data->ride_id?>">자세히 보기</a></div>
                </div>
            <?php
            }
        ?>
    </div>
</div>