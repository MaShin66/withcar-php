<link rel="stylesheet" type="text/css" href="../../../static/css/table.css">

<div>
    <div class="head_style">
        <div class="title_style">나의 운행 목록</div>
        <br>
        <div class="div_style">
            <a href="../withcar" class="a_style">홈으로</a>
            <span class="span_style"></span>
            <a href="./ridelist" class="a_style">새로고침</a>
        </div>
    </div>

    <div class="table_style">
        <?php
            foreach($return_value as $data) { ?>
                <div class="tdata_style">
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
                    <div>출발지 <?=$data->depature;?></div>
                    <div>도착지 <?=$data->destination;?></div>
                    <div>거리 <?=$data->drive_distance;?></div>
                    <div>시간 <?=$data->drive_time;?></div>
                    <div>금액 <?=$data->withcar_price;?></div>
                    <div>결제방법 <?=$data->payment;?></div>
                    <div>운행 생성 날짜 <?=$data->created;?></div>
                    <div><a href="../ride/<?=$data->ride_id?>">자세히 보기</a></div>
                </div>
            <?php
            }
        ?>
    </div>
</div>