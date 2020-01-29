<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href=<?=base_url()?>static/css/head.css>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <title>WithCar</title>

</head>
<body style="margin: 0; padding: 0;">

<div class="menu_style" onclick="openNav()">&#9776; 메뉴</div>
<div class="logo_style"><a href=<?=site_url()?>/withcar class="btn btn-primary">WithCar</a></div>
<div class="head_right_style"></div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php 
    if($this->session->userdata('is_login') === true) { ?>
        <div class="name_style"><h1><a style="color: cornflowerblue;" href=<?=site_url()?>/withcar/editprofile/<?=$session_data['user_id']?>><?=$session_data['user_name']?></a></h1></div>
        <div><h1><a href=<?=site_url()?>/withcar/logout>로그아웃</a></h1></div>
        <div><h1><a href=<?=site_url()?>/withcar/ridelist>대기중인<br>전체 경로</a></h1></div>
    <?php
        if($this->session->userdata('is_driver') === '1') { ?>
            <div><h1><a href=<?=site_url()?>/withcar/my_route/<?=$session_data['user_id']?>>운전자모드: 내가 운행한 경로 보기</a></h1></div>
        <?php
        } else { ?>
            <div><h1><a href=<?=site_url()?>/withcar/my_route/<?=$session_data['user_id']?>>탑승자모드: 내가 등록한 경로 보기</a></h1></div>
            <div><h1><a href=<?=site_url()?>/withcar/driver_enroll/<?=$session_data['user_id']?>>운전자 등록하기</a></h1></div>
        <?php
        }
    } else { ?>
        <div><h1><a href=<?=site_url()?>/withcar/login>로그인</a></h1></div>
        <div><h1><a href=<?=site_url()?>/withcar/signup>회원가입</a></h1></div>
    <?php 
    }
?>
</div>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "220px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>