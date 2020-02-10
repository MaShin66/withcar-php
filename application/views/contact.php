<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

<div class="">
    <a href="javascript:void chatChannel()">
        <img src="https://developers.kakao.com/assets/img/about/logos/channel/consult_small_yellow_pc.png"/>
    </a>
</div>
<script type='text/javascript'>
  //<![CDATA[
    // 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('72b5c774f6586e5ca816568729a64c74');
    function chatChannel() {
      Kakao.Channel.chat({
        channelPublicId: '_krxfCxb' // 카카오톡 채널 홈 URL에 명시된 id로 설정합니다.
      });
    }
  //]]>
</script>