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
    </style>

</head>
<body style="margin: 0; padding: 0;">

<div class="menu_style" onclick="openNav()">&#9776; 메뉴</div>
<!-- <div class="logo_style"><a href=<?=site_url()?>/withcar class="btn btn-primary main_title">WithCar</a></div> -->
<div class="logo_style"><a href=<?=site_url()?>/withcar><img src=<?=base_url()?>/static/img/mini_logo.jpeg></a></div>
<div class="head_right_style"></div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php 
    if($this->session->userdata('is_login') === true) { ?>
        <div class="name_style"><h1><a style="color: cornflowerblue;" href=<?=site_url()?>/withcar/editprofile/<?=$session_data['user_id']?>><?=$session_data['user_name']?> <i class="fas fa-user-edit"></i></a></h1></div>
        <div><h1><a href=<?=site_url()?>/withcar/logout>로그아웃</a></h1></div>
    <?php
        if($this->session->userdata('is_driver') === '1') { ?>
            <div><h1><a href=<?=site_url()?>/withcar/ridelist>대기중인 운행</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/my_route/<?=$session_data['user_id']?>>모든 나의 운행</a></h1></div>
        <?php
        } else if($this->session->userdata('is_driver') === '0') { ?>
            <div><h1><a href=<?=site_url()?>/withcar/ridelist>대기중인 나의 운행</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/my_route/<?=$session_data['user_id']?>>모든 나의 운행</a></h1></div>
        <?php
        }
    } else { ?>
        <div><h1><a href=<?=site_url()?>/withcar/login>로그인</a></h1></div>
        <div><h1><a href=<?=site_url()?>/withcar/signup>회원가입</a></h1></div>
    <?php 
    }
?>

<div class="side_footer">
    <!-- <div><a href="">서비스 정보</a></div> -->
    <div><a href="javascript:void chatChannel()">
        <img src="https://developers.kakao.com/assets/img/about/logos/channel/consult_small_yellow_pc.png"/>
    </a></div>
    
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
</script>