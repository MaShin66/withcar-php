<link rel="stylesheet" type="text/css" href="../../static/css/table.css">

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
                        <span>탑승자 <?=$data->user_name?></span>
                        <span class="status_style">상태 <?=$data->status?></span>
                    </div>
                    <div>출발지 <?=$data->depature?></div>
                    <div>도착지 <?=$data->destination?></div>
                    <div>거리 <?=$data->drive_distance;?> km</div>
                    <div>시간 <?=$data->drive_time;?> 분</div>
                    <div>금액 <?=$data->withcar_price;?> 원</div>
                    <div>결제방법 <?=$data->payment;?></div>
                    <div><a href="ride/<?=$data->ride_id?>">자세히 보기</a></div>
                </div>
            <?php
            }
        ?>
    </div>
</div>