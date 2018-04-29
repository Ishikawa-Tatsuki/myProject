<?php
  session_start();

  $_SESSION = array();

  setcookie(session_name(),"",time()-60);

  $logout = session_destroy();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <script type="text/javascript">
      window.onload = function(){
        window.location.href = "bbs.php";
      };
    </script>
  </body>
</html>
