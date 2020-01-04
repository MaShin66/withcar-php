<h1>드라이버 등록</h1>

<form action="../driver_enroll2/<?=$user_id?>" method="post">
    <input type="hidden" name="is_driver" value=1>
    자동차 운전면허증 번호 <input type="text" name="license_number">
    <br><br>
    차량정보 등록
    <br>
    차량 번호 <input type="text" name="car_number" placeholder="11가1111">
    <br>
    차종 <input type="text" name="car_name" placeholder="소나타">
    <br><br>
    이체받을 계좌번호 입력
    <br>
    은행 <input type="text" name="bank">
    <br>
    예금주 <input type="text" name="account_holder">
    <br>
    계좌번호 <input type="text" name="account">
    <br>

    <input type="submit" value="드라이버 등록 완료">
</form>