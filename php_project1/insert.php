<?php

  session_start();

  require_once 'db_access.php';

  $login = false;
  $user_name = "";
  $user_id = 0;
  $thread_id = "";
  $insert_error = false;
  $is_post = false;

  if(isset($_SESSION["user_name"])&&isset($_SESSION["user_id"])){
    $user_name = $_SESSION["user_name"];
    $user_id = $_SESSION["user_id"];
    $login = true;
  }



  if($login){
      if (isset($_POST['title'])&&isset($_POST['content'])&&isset($_POST['user_id'])&&isset($_POST['thread_id'])){
          $_POST['title'] = htmlspecialchars($_POST['title'],ENT_QUOTES,"UTF-8");
          $_POST['user_id'] = htmlspecialchars($_POST['user_id'],ENT_QUOTES,"UTF-8");
          $_POST['content'] = htmlspecialchars($_POST['content'],ENT_QUOTES,"UTF-8");
          $thread_id = $_POST['thread_id'];
          $sql = "insert into posts values (null,null,'".$_POST['title']."','".$_POST['content']."',".$thread_id.",".$_POST['user_id'].")";
          $insert_error = !(db_access("bbs", $sql));
          $is_post = true;
      }elseif(isset($_POST['title'])&&isset($_POST['user_id'])&&isset($_POST['description'])){
          $_POST['title'] = htmlspecialchars($_POST['title'],ENT_QUOTES,"UTF-8");
          $_POST['user_id'] = htmlspecialchars($_POST['user_id'],ENT_QUOTES,"UTF-8");
          $_POST['description'] = htmlspecialchars($_POST['description'],ENT_QUOTES,"UTF-8");
          $result = db_access("bbs","insert into threads values (null,"."'".$_POST['title']."'".",null,".$_POST['user_id'].","."'".$_POST['description']."'".",0,false)");
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
    <?php if($login){
        if($is_post){
      ?>
      <script type="text/javascript">
        window.onload = function(){
          window.location.href = "posts.php?thread_id=<?= $thread_id?>&insert_error=<?= $insert_error ?>";
        };
      </script>
    <?php }else{ ?>
      <script type="text/javascript">
        window.onload = function(){
          window.location.href = "bbs.php";
        };
      </script>
    <?php   }}else{?>
      <script type="text/javascript">
        window.onload = function(){
          window.location.href = "bbs.php";
        };
      </script>
  <?php }?>
  </body>
</html>
