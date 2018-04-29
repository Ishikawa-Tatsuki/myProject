<?php

session_start();

require_once 'db_access.php';

$login = false;
$ids = "";
$request_ids = "";
$location = "#";

if(isset($_SESSION["user_name"])&&isset($_SESSION["user_id"])){
  $user_name = $_SESSION["user_name"];
  $user_id = $_SESSION["user_id"];
  $login = true;
}

if ($login) {
  if (isset($_POST['ids'])) {
    $ids = explode(',',$_POST['ids']);
    for ($i=0; $i <count($ids) ; $i++) {
      $sql = "delete from posts where id = ".$ids[$i];
      db_access("bbs",$sql);
      $location = "#user_posts";
    }
  }elseif(isset($_POST['delete_request'])){
    $request_ids = explode(',',$_POST['delete_request']);
    for ($i=0; $i <count($request_ids); $i++) {
      $sql = "update threads set is_requested = true where id = ".$request_ids[$i];
      db_access("bbs",$sql);
      $location = "#user_threads";
    }
  }elseif(isset($_POST['cancel_request'])){
    $sql = "update threads set is_requested = false where id = ".$_POST['cancel_request'];
    db_access("bbs",$sql);
    $location = "#user_threads";
  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php if ($login){ ?>
      <script type="text/javascript">
        window.location.href = "profile.php<?= $location?>";
      </script>
    <?php }else{ ?>
      <script type="text/javascript">
        window.location.href = "bbs.php";
      </script>
    <?php } ?>
  </body>
</html>
