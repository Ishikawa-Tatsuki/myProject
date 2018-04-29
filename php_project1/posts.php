<?php

    session_start();

    require_once 'db_access.php';


    $login_error = false;
    // $insert_error = false;
    $login = false;
    //  debug
    // $login = true;
    $thread_id = 0;
    $user_name = "";
    $user_id = 0;
    $insert_error = false;

    if(isset($_SESSION["user_name"])&&isset($_SESSION["user_id"])){
      $user_name = $_SESSION["user_name"];
        $user_id = $_SESSION["user_id"];
        $login = true;
        if (isset($_GET["thread_id"])) {
          $thread_id = $_GET["thread_id"];
        }elseif(isset($_POST["thread_id"])){
          $thread_id = $_POST["thread_id"];
        }
        if(isset($_GET['insert_error'])){
          $insert_error = $_GET['insert_error'];
        }
    }else{
          $login_error = true;
    }

    // if($login){
    //     if (isset($_POST['title'])&&isset($_POST['content'])&&isset($_POST['user_id'])){
    //         $_POST['title'] = htmlspecialchars($_POST['title'],ENT_QUOTES,"UTF-8");
    //         $_POST['user_id'] = htmlspecialchars($_POST['user_id'],ENT_QUOTES,"UTF-8");
    //         $_POST['content'] = htmlspecialchars($_POST['content'],ENT_QUOTES,"UTF-8");
    //         $sql = "insert into posts values (null,null,'".$_POST['title']."','".$_POST['content']."',".$thread_id.",".$_POST['user_id'].")";
    //         $insert_error = !(db_access("bbs", $sql));
    //     }else{
    //
    //     }
    // }
 ?>

 <html lang="ja">
   <head>
     <meta charset = "utf-8">
     <meta http-equiv = "Content-Type" content = "text/html">
     <title>Post.php</title>
     <meta name = "author" content = "Ishikawa" >
     <meta name = "keywords" content = "BBS workport Volume2 Task">
     <meta name = "description" content = "this is bulletin board, which has some simple functions:User Authentication, search words, access management,paging and so on">
     <link rel="icon" type="image/vnd.microsoft.icon"href = "/Task1/img/favicon.ico">
     <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
     <meta name="viewport" content="width = device-width,initial-scale = 1.0">
     <link rel = "stylesheet" type = "text/css" href = "css/base.css">
     <script type = "text/javascript" src="js/jquery-3.3.1.js"></script>
     <style media="screen">
       body{
         background-color: #EFEFEF;
       }
       table.post{
         background-color: white;
       }
       form#post{
         background-color: white;
       }
       table.post{
         font-family: Arial,Meiryo,メイリオ;
       }
     </style>
   </head>
   <body>

     <?php if($login){?>

     <header>
       <a href="bbs.php"><h1>Bulletin Board</h1></a>
       <div id = "login_user">
         <div class="login_name"><?=$user_name ?>さん</div>
         <div class="user_profile"><a href="profile.php">User Setting</a></div>
         <div class="logout">Logout</div>
       </div>
     </header>

     <div id = "main">
     <?php
       try{
          $posts = db_access("bbs", "select users.name, posts.date, title, content from posts inner join users on posts.user_id = users.id where thread_id =".$thread_id);
       }catch(Exception $e){
         echo "db error";
       }
     ?>

   <!-- post error report -->

   <?php if($insert_error){?>
     <p class="error">投稿時にエラーが発生しました。
   <?php }?>

   <!-- post error report -->


     <?php  while ($post = mysqli_fetch_array($posts)){
            $post["content"] = nl2br($post["content"]);
            $post["content"] = str_replace("\n","",$post["content"]);
       ?>
       <table class="post">
         <tbody>
           <tr class="post_title"><th><?=$post['title'] ?></th></tr>
           <tr class="post_detail"><th><?=$post['name'] ?>  <?=$post['date'] ?></th></tr>
           <tr class="post_content"><td><?=$post['content'] ?></td></tr>
         </tbody>
       </table>
     <?php }?>

     <form id="post" action = "insert.php" method = "post">
       <fieldset>
         <legend>投稿フォーム</legend>
         <span>投稿者 : <?= $user_name?></span>
         <table class="post_form">
           <tbody>
             <tr><th>題名　　<input type = "text" name = "title" value = "" required></th></tr>
             <tr><td>投稿内容</td></tr>
             <tr>
               <td><textarea wrap="hard" cols= "55" rows = "10" name = "content" required></textarea><br></td>
             </tr>
             <tr><td>画像アップロード<input type="file" name="image"></td></tr>
             <tr>
               <td>
                 <input type = "submit" title = "この内容で掲示板に投稿します" value = "投稿する">
                 <input type = "reset" title = "内容をリセットします" value = "内容をリセットする">
               </td>
             </tr>
           </tbody>
         </table>
           <input type = "hidden"  name = "user_id" value ="<?=$user_id ?>">
           <input type = "hidden" name = "thread_id" value = "<?=$thread_id ?>">
       </fieldset>
     </form>

     </div>
     <script type="text/javascript">
       $('div.logout').on('click',function(){
         window.location.href = "logout.php";
       })
     </script>
   <?php }else{?>
     <script type="text/javascript">
       window.onload = function(){
         window.location.href = "bbs.php";
       };
     </script>
   <?php } ?>
     </body>
 </html>
