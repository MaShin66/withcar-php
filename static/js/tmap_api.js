function initTmap(){
    var map = new Tmap.Map({
        div:'map_div',  // 결과 지도를 표시할 곳
        width : "100%",  // 가로와 세로 사이즈는 픽셀로 적을 수도 있고
        height : "50%", // 퍼센트로 적을 수도 있다. 홈페이지 예제는 픽셀로 되어 있음.
    });
    // 경로 탐색 출발지점과 도착 지점의 좌표
    // 구글 지도에서 나오는 좌표의 x, y를 바꾸면 된다.     
    var startX = depature_latitude;
    var startY = depature_longitude;
    var endX = destination_latitude;
    var endY = destination_longitude;
    var passList = null;
    var prtcl;
    var headers = {};

    headers["appKey"]="da7b106e-e761-42bd-948c-e1dd2a1d66d5"; // 발급받은 인증키를 넣어야 한다
    $.ajax({
        method:"POST",
        headers : headers,
        url:"https://api2.sktelecom.com/tmap/routes?version=1&format=xml",
        async:false,
        data:{
            startX : startX,
            startY : startY,
            endX : endX,
            endY : endY,
            passList : passList,
            reqCoordType : "WGS84GEO",
            resCoordType : "EPSG3857",
            angle : "172",
            searchOption : "0",
            trafficInfo : "Y" //교통정보 표출 옵션입니다.
        },

        success:function(response){ //API가 제대로 작동할 경우 실행될 코드
            prtcl = response;

            // 결과 출력 부분 - 여기는 잘 모르겠음.
            var innerHtml ="";
            var prtclString = new XMLSerializer().serializeToString(prtcl);//xml to String
            xmlDoc = $.parseXML( prtclString ),
            $xml = $( xmlDoc ),
            $intRate = $xml.find("Document");

            var tDistance = " 총 거리 : "+($intRate[0].getElementsByTagName("tmap:totalDistance")[0].childNodes[0].nodeValue/1000).toFixed(1)+"km,";
            var tTime = " 총 시간 : "+($intRate[0].getElementsByTagName("tmap:totalTime")[0].childNodes[0].nodeValue/60).toFixed(0)+"분,";
            var tFare = " 총 요금 : "+$intRate[0].getElementsByTagName("tmap:totalFare")[0].childNodes[0].nodeValue+"원,";
            var taxiFare = " 예상 택시 요금 : "+$intRate[0].getElementsByTagName("tmap:taxiFare")[0].childNodes[0].nodeValue+"원";

            document.getElementById("drive_distance").value = ($intRate[0].getElementsByTagName("tmap:totalDistance")[0].childNodes[0].nodeValue/1000).toFixed(1); 
            document.getElementById("drive_time").value = ($intRate[0].getElementsByTagName("tmap:totalTime")[0].childNodes[0].nodeValue/60).toFixed(0)
            document.getElementById("taxi_price").value = $intRate[0].getElementsByTagName("tmap:taxiFare")[0].childNodes[0].nodeValue
            document.getElementById("withcar_price").value = ($intRate[0].getElementsByTagName("tmap:taxiFare")[0].childNodes[0].nodeValue)*0.75

            $("#result").text(tDistance+tTime+tFare+taxiFare);

            // 실시간 교통정보 추가
            var trafficColors = {
                extractStyles:true,
                /* 실제 교통정보가 표출되면 아래와 같은 Color로 Line이 생성됩니다. */
                trafficDefaultColor:"#000000", //Default
                trafficType1Color:"#009900", //원활
                trafficType2Color:"#8E8111", //지체
                trafficType3Color:"#FF0000", //정체
            };    
            var kmlForm = new Tmap.Format.KML(trafficColors).readTraffic(prtcl);
            routeLayer = new Tmap.Layer.Vector("vectorLayerID"); //백터 레이어 생성
            routeLayer.addFeatures(kmlForm); //교통정보를 백터 레이어에 추가   

            map.addLayer(routeLayer); // 지도에 백터 레이어 추가

            // 경로탐색 결과 반경만큼 지도 레벨 조정
            map.zoomToExtent(routeLayer.getDataExtent());
        },
        error:function(request,status,error){ // API가 제대로 작동하지 않을 경우
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    });
}