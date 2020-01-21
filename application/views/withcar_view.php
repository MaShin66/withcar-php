<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=72b5c774f6586e5ca816568729a64c74&libraries=services"></script>
<link rel="stylesheet" type="text/css" href="../../static/css/kakaomap_api.css">
<link rel="stylesheet" type="text/css" href="../../static/css/withcar_view.css">

<style>
.map_wrap {
    margin: 10px;
    
}

.from_div {
    margin-top: 18px;
}

.map_style {
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
}
</style>


<div class="map_wrap">
    <div id="map" class="map_style"></div>
    <div id="menu_wrap" class="bg_white">
        <div class="option">
            <div>
                <form onsubmit="searchPlaces(); return false;">
                    키워드 : <input type="text" value="" id="keyword" size="15">
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
    <div class="form_div">
        <div class="place_div">출발지<input type="text" id="depature" name="depature"></div>
        <input type="hidden" id="depature_latitude" name="depature_latitude">
        <input type="hidden" id="depature_longitude" name="depature_longitude">

        <div class="place_div">도착지<input type="text" id="destination" name="destination"></div>
        <input type="hidden" id="destination_latitude" name="destination_latitude">
        <input type="hidden" id="destination_longitude" name="destination_longitude">

        <div class="place_div">
            <div><input type="date" id="date_value" name="date_value"></div>
            <div><input type="time" id="time_value" name="time_value"></div>
        </div>
        
        <div class="place_div submit_style">
            <input type="submit" value="예상 경로와 금액 확인">
        </div>
    </div>
</form>


<script src="../../static/js/kakaomap_api.js"></script>

<script>
    var timezoneOffset = new Date().getTimezoneOffset() * 60000;
    var timezoneDate = new Date(Date.now() - timezoneOffset);

    document.getElementById('date_value').value = timezoneDate.toISOString().slice(0, 10);
    document.getElementById('time_value').value = timezoneDate.toISOString().slice(11, 16);
</script>