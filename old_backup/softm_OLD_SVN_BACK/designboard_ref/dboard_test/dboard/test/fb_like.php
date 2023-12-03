<!doctype html>

<!--XML namespace 추가-->
<html xmlns:fb="http://ogp.me/ns/fb#">

<html>
    <body>
        <div id="fb-root"></div>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '1422179344726962', // 앱 ID
              status     : true,          // 로그인 상태를 확인
              cookie     : true,          // 쿠키허용
              xfbml      : true           // parse XFBML
            });
   
            // 추가적인 코드는 여기에 작성해주세요.
          };
        
          // Load the SDK Asynchronously
          (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/ko_KR/all.js";
             ref.parentNode.insertBefore(js, ref);
           }(document));
        </script>
        
        <p>like</p>
        <!---fb:like send="true" width="450" show_faces="true" data-action="recommend"></fb:like-->

        <div class="fb-like" data-href="http://www.da.net/aaa.b2.html" data-layout="standard" data-action="like" data-show-faces="true" data-share="true" colorscheme="dark" data-kid-directed-site="true"></div>
        <a href="#" onclick="FB.logout();">[logout]</a><br/>
  </body>
 </html>