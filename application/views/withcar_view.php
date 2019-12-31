<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=72b5c774f6586e5ca816568729a64c74&libraries=services"></script>
<link rel="stylesheet" type="text/css" href="../../static/css/kakaomap_api.css">

<?php 
    if($this->session->userdata('is_login') === true) { ?>
        <div><?=$session_data['user_name']?>님 안녕하세요</div>
        <div><h1><a href="withcar/logout">로그아웃</a></h1></div>
        <div><h1><a href="withcar/ridelist">등록된 전체 경로</a></h1></div>
    <?php
        if($this->session->userdata('is_driver') === '1') { ?>
            <div><h1><a href="withcar/my_route/<?=$session_data['user_id']?>">운전자모드: 내가 운행한 경로 보기</a></h1></div>
        <?php
        } else { ?>
            <div><h1><a href="withcar/my_route/<?=$session_data['user_id']?>">탑승자모드: 내가 등록한 경로 보기</a></h1></div>
            <div><h1><a href="withcar/driver_enroll/<?=$session_data['user_id']?>">운전자 등록하기</a></h1></div>
        <?php
        }
    } else { ?>
        <div><h1><a href="withcar/login">로그인</a></h1></div>
        <div><h1><a href="withcar/signup">회원가입</a></h1></div>
    <?php 
    }
?>



<div class="map_wrap">
    <div id="map" style="width: 100%; height: 100%; position: relative; overflow: hidden;"></div>

   <div id="menu_wrap" class="bg_white">
       <div class="option">
           <div>
               <form onsubmit="searchPlaces(); return false;">
                   키워드 : <input type="text" value="이태원 맛집" id="keyword" size="15">
                   <button type="submit">검색하기</button>
               </form>
           </div>
       </div>
       <hr>
       <ul id="placesList"></ul>
       <div id="pagination"></div>
</div>

</div>

<form action="withcar/ride_route" method="post">
    <div>출발지<input type="text" id="depature" name="depature"></div>
    <input type="hidden" id="depature_latitude" name="depature_latitude">
    <input type="hidden" id="depature_longitude" name="depature_longitude">

    <div>도착지<input type="text" id="destination" name="destination"></div>
    <input type="hidden" id="destination_latitude" name="destination_latitude">
    <input type="hidden" id="destination_longitude" name="destination_longitude">

    <div>시간 설정하기</div>
    
    <div><input type="submit" value="예상 경로와 금액 확인">
</form>

<script src="../../static/js/kakaomap_api.js"></script>