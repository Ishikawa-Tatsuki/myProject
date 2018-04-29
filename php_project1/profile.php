<?php

    session_start();

    require_once 'db_access.php';


    $login_error = false;
    $login = false;
    //  debug
    // $login = true;
    $user_name = "";
    $user_id = 0;
    $user_email = "";

    if(isset($_SESSION["user_name"])&&isset($_SESSION["user_id"])){
      $user_name = $_SESSION["user_name"];
      $user_id = $_SESSION["user_id"];
      $user_email = get_user_email($user_id);
      $login = true;
    }else{
        $login_error = true;
    }

 ?>

 <html lang="ja">
   <head>
     <meta charset = "utf-8">
     <meta http-equiv = "Content-Type" content = "text/html">
     <title>Profile.php</title>
     <meta name = "author" content = "Ishikawa" >
     <meta name = "keywords" content = "BBS workport Volume2 Task">
     <meta name = "description" content = "this is bulletin board, which has some simple functions:User Authentication, search words, access management,paging and so on">
     <link rel="icon" type="image/vnd.microsoft.icon"href = "/Task1/img/favicon.ico">
     <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
     <meta name="viewport" content="width = device-width,initial-scale = 1.0">
     <link rel = "stylesheet" type = "text/css" href = "css/base.css">
     <script type = "text/javascript" src="js/jquery-3.3.1.js"></script>
     <script type="text/javascript">
       var posts_select = false;
       var threads_select = false;
     </script>
   </head>
   <body>

     <?php if($login){?>

     <header>
       <a href="bbs.php"><h1>Bulletin Board</h1></a>
       <div id = "login_user">
         <div class="login_name"><?=$user_name ?>さん</div>
         <div class="user_profile">User Setting</div>
         <div class="logout">Logout</div>
       </div>
     </header>

     <div id = "main">

       <?php
         try{
            $user_data = db_access("bbs", "select posts_num, threads_num, is_admin,img,adress,gender,age from users where id =".$user_id);
            $user = mysqli_fetch_array($user_data);
            // var_dump($user_data);
         }catch(Exception $e){
           echo "db error";
         }
       ?>

       <div id="user_profile">
         <!-- <h1>Your Profile</h1> -->
       <?php if($user['is_admin']){ ?>
         <div class="img_wrapper">
            <img src="img/admin.png" width="200px" height="200px"alt="">
         </div>
       <?php }else{ ?>
         <div class="img_wrapper">
            <img src="img/usr.png" width="200px" height="200px"alt="">
         </div>
       <?php } ?>
         <div class="user_name">
           <label>Name  </label><?= $user_name ?>
         </div>
         <div class="user_email">
           <label>Email </label>
           <?php
           if($user_email != " "){
             echo $user_email;
           }else{
             echo "undefined";
           }?>
         </div>
         <!-- <div class="user_details">
           <div class="age_wrapper">
             <label for="age">Age</label>
             <input type="text" name="age" value="" id="age">
           </div>
           <div class="gender_wrapper">
             <input type="radio" name="gender" value="male" id="male" checked><label for="male">Male</label>
             <input type="radio" name="gender" value="female" id="female"><label for="female">Female</label>
           </div>
           <div class="address_wrapper">
             <label for="address">Address</label>
             <input type="text" name="address" value="" id="address">
           </div>
         </div> -->
       </div>
     <?php
       try{
          $posts = db_access("bbs", "select  id,date, thread_id,title, content from posts where user_id =".$user_id);
       }catch(Exception $e){
         echo "db error";
       }
     ?>

      <div id="user_posts">
        <h1> <?= $user['posts_num']?> Posts</h1>
      <div class="select_wrapper"><div class="select_posts">SELECT</div><div class="delete_posts">DELETE</div></div>
     <?php  while ($post = mysqli_fetch_array($posts)){
            $post["content"] = nl2br($post["content"]);
            $post["content"] = str_replace("\n","",$post["content"]);
       ?>
      <div class="post_wrapper_wrapper">
        <div class="post_wrapper">
          <a href="posts.php?thread_id=<?= $post['thread_id']?>" target="_blank">
           <table class="post">
             <tbody>
               <tr class="post_title"><th><div><?=$post['title'] ?></div></th></tr>
               <tr class="post_detail"><th><?=$post['date'] ?></th></tr>
               <tr class="post_content"><td><div><?=$post['content'] ?></div></td></tr>
               <tr class="post_id"><th><?=$post['id'] ?></th></tr>
             </tbody>
            </table>
           </a>
          </div>
        </div>
     <?php }?>

     </div>
     <?php
       try {
           $threads = db_access("bbs","SELECT threads.id as thread_id,title, is_requested,threads.date, description,threads.posts_num FROM threads where user_id = ".$user_id);
       } catch (\Exception $e) {

       }
     ?>

      <div id="user_threads">
        <h1><?= $user['threads_num']?> Threads</h1>

      <div class="select_wrapper"><div class="select_threads">SELECT</div><div class="delete_threads">REQUEST</div></div>
     <?php while ($thread = mysqli_fetch_array($threads)) {
         $thread['description'] = nl2br($thread['description']);
         $thread['description'] = str_replace("\n","",$thread['description']);
       ?>
      <div class="thread_wrapper">
       <a href="posts.php?thread_id=<?= $thread['thread_id']?>" target="_blank">
         <div class="thread">
           <div class="Ttitle"><?=$thread['title']  ?></div>
           <div class="Tdate">Last post : <?=$thread['date']  ?></div>
           <div class="Tposts">Total : <?=$thread['posts_num']  ?>Posts</div>
           <div class="Tdescription"><?=$thread['description']  ?></div>
           <div class="thread_id"><?= $thread['thread_id']?></div>
         </div>
       </a>
       <?php if($thread['is_requested']){?>
            <label class="requested"></label>
       <?php }?>
      </div>
     <?php } ?>
      </div>
     </div>
     <script type="text/javascript">
       $('div.logout').on('click',function(){
         window.location.href = "logout.php";
       });
       $('div.select_posts').on('click',function(){
         if (!posts_select) {
           $('div.select_posts').addClass("active");
           $('div#user_posts div.post_wrapper').addClass("static");
           posts_select = true;
         }else {
           $('div.select_posts').removeClass("active");
           posts_select = false;
           $('div.post_wrapper_wrapper.selected').removeClass('selected');
           $('div#user_posts div.post_wrapper').removeClass("static");
         }
       });
       $('div#user_posts div.post_wrapper').on('click',function(e){
         if (posts_select) {
           e.preventDefault();
           $(e.target).parent().parent().toggleClass('selected');
         }
       });
       $('div.delete_posts').on('click',function () {
         var ids = new Array();
         $('div#user_posts div.post_wrapper_wrapper.selected tr.post_id th').each(function (index,element) {
          ids.push($(element).text());
         });
         if (ids.length != 0) {
           $('<form>',{action:"delete.php",method:'post'}).append($('<input>',{type:'hidden',name:'ids',value:ids})).appendTo(document.body).submit();
         }
       });
       $('div.select_threads').on('click',function(){
         if (!threads_select) {
           $('div.select_threads').addClass("active");
           $('div#user_threads div.thread_wrapper').addClass("static");
           threads_select = true;
         }else {
           $('div.select_threads').removeClass("active");
           threads_select = false;
           $('div.thread_wrapper.selected').removeClass('selected');
           $('div#user_threads div.thread_wrapper').removeClass("static");
         }
       });
       $('div#user_threads div.thread_wrapper').on('click',function(e){
         if (threads_select) {
           $(e.target).toggleClass('selected');
         }
       });
       $('div.delete_threads').on('click',function () {
         var thread_ids = new Array();
         $('div#user_threads div.thread_wrapper.selected div.thread_id').each(function (index,element) {
          thread_ids.push($(element).text());
         });
         if (thread_ids.length != 0) {
           $('<form>',{action:"delete.php",method:'post'}).append($('<input>',{type:'hidden',name:'delete_request',value:thread_ids})).appendTo(document.body).submit();
         }
       });
       if ($('div#user_threads div.thread_wrapper label.requested').length) {
         $('div#user_threads div.thread_wrapper label.requested').on('click',function(e){
           if ( window.confirm("削除申請を取り下げますか？")) {
             var request_id = $(e.target).parent().find('div.thread_id').text();
             console.log(request_id);
             if (request_id != "") {
                $('<form>',{action:"delete.php",method:'post'}).append($('<input>',{type:'hidden',name:'cancel_request',value:request_id})).appendTo(document.body).submit();
             }
           }
         });
       }
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
