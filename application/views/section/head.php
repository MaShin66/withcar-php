<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href=<?=base_url()?>static/css/head.css>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

    <title>WithCar</title>

    <style>
    .main_title {
        padding: 8px 18px;
        font-size: 16px;
    }

    .switch_button {
      width: 100%;
      background-color: #111;
      border: 0;
      padding-left: 34px;
    }

    .switch_div {
      background-color: white;
      width: 100%;
      height: 42px;
      border-radius: 25px;
      display: flex;
    }

    .move_div {
      width: 39%;
      height: 42px;
      border-radius: 100%;
      background-color: darkslateblue;  
    }

    .move_div:active {
      transform: translate(63px, 0);
      transition: 0.5s;
    }

    .driver_font {
      font-size: 1.7rem;
      font-weight: bold;
      margin: auto;
    }

    </style>

</head>
<body style="margin: 0; padding: 0;">

<div class="head_style">
  <div class="menu_style" onclick="openNav()">&#9776; 메뉴</div>
  <div class="logo_style"><a href=<?=site_url()?>/withcar><img src=<?=base_url()?>/static/img/mini_logo.jpeg></a></div>
  <!-- <div class="head_right_style"></div> -->
</div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php 
    if($this->session->userdata('is_login') === true) {
    $session_data = $this->session->userdata();
    ?>
    <!-- 로그인이 됐다면 -->
        <div class="name_style"><h1><a style="color: cornflowerblue;" href=<?=site_url()?>/withcar/editprofile/<?=$session_data['user_id']?>><?=$session_data['user_name']?> <i class="fas fa-user-edit"></i></a></h1></div>
        <div><h1><a href=<?=site_url()?>/withcar/logout>로그아웃</a></h1></div>
    <?php
        if($this->session->userdata('is_driving') === '1' && $this->session->userdata('user_id') !== '1') { ?>
        <!-- 드라이버모드 + 관리자 X -->
            <div><h1><a href=<?=site_url()?>/withcar/onroute_ride/<?=$session_data['user_id']?>>운행중</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/requested_ride/<?=$session_data['user_id']?>>승인한 운행</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/ridelist>대기중인 운행</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/my_route/<?=$session_data['user_id']?>>운행 내역</a></h1></div>
        <?php
        } else if($this->session->userdata('is_driving') === '0' && !$this->session->userdata('user_id') !== '1') { ?>
        <!-- 탑승자 모드 + 관리자 X -->
            <div><h1><a href=<?=site_url()?>/withcar/onroute_ride/<?=$session_data['user_id']?>>운행중</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/requested_ride/<?=$session_data['user_id']?>>승인된 운행</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/ridelist>등록한 운행</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/my_route/<?=$session_data['user_id']?>>운행 내역</a></h1></div>
            
        <?php
        }
        if($this->session->userdata('user_id') === '1') { ?>
        <!-- 관리자라면  -->
          <div><h1><a href=<?=site_url()?>/withcar/total_user>이용자 관리</a></h1></div>
          <div><h1><a href=<?=site_url()?>/withcar/total_calculate>정산 관리</a></h1></div>
        <?php
        }
    } else { ?>
    <!-- 로그인이 안됐다면 -->
        <div><h1><a href=<?=site_url()?>/withcar/login>로그인</a></h1></div>
        <div><h1><a href=<?=site_url()?>/withcar/signup>회원가입</a></h1></div>
    <?php 
    }
?>

  <div class="side_footer">
    <?php
      if($this->session->userdata('is_login') === false) {
        // 로그아웃시에는 아무것도 안보여주고
      } else if($this->session->userdata('is_login') === true) {
        if($this->session->userdata('is_driving') === '1') { ?>
        <!-- 로그인 + 드라이버 모드라면 탑승자로 바꿀 수 있는 버튼 -->
          <button type="button" class="switch_button" onclick="move_div_ftn()">
            <div class="switch_div" style="background-color: lightpink;">
            <div class="driver_font">드라이빙</div>
            <div id="move_div" class="move_div"></div>
            </div>
          </button>
        <?php
        } else if($this->session->userdata('is_driving') === '0' && $this->session->userdata('is_driver') === '1') { ?>
        <!-- 로그인 + 탑승자 모드 + 운전 등록자라면 드라이버로 바꿀 수 있는 버튼 -->
          <button type="button" class="switch_button" onclick="move_div_ftn()">
            <div class="switch_div">
              <div id="move_div" class="move_div"></div>
              <div class="driver_font">드라이빙</div>
            </div>
          </button>
        <?php
        } else if($this->session->userdata('is_driving') === '0' && $this->session->userdata('is_driver') === '0') {
        // 드라이버 등록이 안됐다면 보여줄 수 없으니 빈칸
      }
    }
    ?>
      <div>
        <a href="javascript:void chatChannel()">
          <img src="https://developers.kakao.com/assets/img/about/logos/channel/consult_small_yellow_pc.png"/>
        </a>
      </div>
      
  </div>
</div>

<script type='text/javascript'>
  function openNav() {
    document.getElementById("mySidenav").style.width = "260px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  }

//<![CDATA[
    Kakao.init('72b5c774f6586e5ca816568729a64c74');
    function chatChannel() {
      Kakao.Channel.chat({
        channelPublicId: '_krxfCxb' // 카카오톡 채널 홈 URL에 명시된 id로 설정합니다.
      });
    }
  //]]>
  

function move_div_ftn() {
  var is_driving = '<?=$this->session->userdata('is_driving')?>';  
  
  if(is_driving === '1') {
    move_div.style.transform = "translate(-63px, 0)";
    move_div.style.transition = "0.5s";
    location.href='<?=site_url()?>/withcar/change_mode/<?=$session_data['user_id']?>';
  } else if(is_driving === '0') {
    move_div.style.transform = "translate(63px, 0)";
    move_div.style.transition = "0.5s";
    location.href='<?=site_url()?>/withcar/change_mode/<?=$session_data['user_id']?>';
  }
}

</script>