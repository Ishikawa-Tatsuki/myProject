<?php

        session_start();

        require_once 'db_access.php';

        /* ------------- Fields -------------- */

        $login_error = false;
        $register_error = false;
        $create_thread = true;
        // $insert_error = false;
        $login = false;
        //  debug
        // $login = true;
        $user_name = "";
        $user_id = 0;
        $sql = "";

        /* ------------- Fields -------------- */

        /* ------------- login check -------------- */

        if(isset($_SESSION["user_name"])&&isset($_SESSION["user_id"])&&$_SESSION["user_id"]!=0){
            $user_name = $_SESSION["user_name"];
            $user_id = $_SESSION["user_id"];
            $login = true;
        }else {
            if(isset($_POST['user_name'])&&isset($_POST['password'])){
                $user_name = $_POST['user_name'];
                $pass = $_POST['password'];
                if(user_check($user_name, $pass)){
                    $_SESSION['user_name'] = $user_name;
                    $user_id = get_user_id($user_name,$pass);
                    $_SESSION['user_id'] = $user_id;
                    $login = true;
                }else {
                    $login_error = true;
                }
            }elseif (isset($_POST['name'])&&isset($_POST['pass'])&&isset($_POST['email'])) {
                $user_name = $_POST['name'];
                $pass = $_POST['pass'];
                $email = $_POST['email'];
                if(!user_check($user_name, $pass)){
                    $sql = "insert into users values (null,"."'".$user_name."'".",null,null,null,null,".$email.",null,null,0,'".$pass."')";
                    $result2 = db_access("bbs","insert into users values (null,'".$user_name."',null,null,null,null,'".$email."',0,null,0,'".$pass."')");
                    if ($result2) {
                      $_SESSION['user_name'] = $user_name;
                      $user_id = get_user_id($user_name,$pass);
                      $_SESSION['user_id'] = $user_id;
                      $login = true;
                    }else{
                      $register_error = true;
                    }
                }else {
                    $register_error = true;
                }
            }
        }

        /* ------------- login check -------------- */


        /* ------------- update 'thread' table on 'bbs' databese -------------- */

        // if($login){
        //      if (isset($_POST['title'])&&isset($_POST['user_id'])&&isset($_POST['description'])){
        //        $_POST['title'] = htmlspecialchars($_POST['title'],ENT_QUOTES,"UTF-8");
        //        $_POST['user_id'] = htmlspecialchars($_POST['user_id'],ENT_QUOTES,"UTF-8");
        //        $_POST['description'] = htmlspecialchars($_POST['description'],ENT_QUOTES,"UTF-8");
        //        $result = db_access("bbs","insert into threads values (null,"."'".$_POST['title']."'".",null,".$_POST['user_id'].","."'".$_POST['description']."'".",0,false)");
        //      }
        //  }

        /* ------------- update 'thread' table on 'bbs' databese -------------- */

    ?>

    <html lang="ja">
    	<head>
    		<meta charset = "utf-8">
    		<meta http-equiv = "Content-Type" content = "text/html">
    		<title>BBS.php</title>
    		<meta name = "author" content = "Ishikawa" >
    		<meta name = "keywords" content = "BBS workport Volume2 Task">
    		<meta name = "description" content = "this is bulletin board, which has some simple functions:User Authentication, search words, access management,paging and so on">
        <link rel="icon" type="image/vnd.microsoft.icon"href = "/Task1/img/favicon.ico">
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
        <meta name="viewport" content="width = device-width,initial-scale = 1.0">
    		<link rel = "stylesheet" type = "text/css" href = "css/base.css">
    		<script type = "text/javascript" src="js/jquery-3.3.1.js"></script>
        <script type="text/javascript">
          var user_name = "<?=$user_name ?>";
          var user_id = <?=$user_id ?>;
        </script>
    	</head>
    	<body>

    		<?php if(!$login){?>

        <!-- user register form -->

        <div id="user_register_form">
          <h1>User Register Form</h1>
          <div id="wrapper_register_form">
            <form class="register" action="bbs.php" method="post">
              <div class="input_wrapper">
                <input class="input_text" type="text" name="name" value="" required>
                <label class="input_label"for="name">Enter Your Name</label>
              </div>
              <div class="input_wrapper">
                <input class="input_email" type="email" name="email" value="" required>
                <label class="input_label"for="email">Enter Email Address</label>
              </div>
              <div class="input_wrapper  password">
                <input class="input_pass" type="password" name="pass" value="" required>
                <label class="input_label"for="pass">Enter Password</label>
              </div>
              <div class="input_wrapper  password">
                <input class="input_repass" type="password" name="pass2" value="" required>
                <label class="input_label"for="name">Re Enter Password</label>
              </div>
              <label class="error">パスワードが一致しません。</label>
              <input type = "submit" value = "register">&nbsp;&nbsp;
    				  <input type = "reset" value = "reset">
            </form>
          </div>
          <div class="close_pane">Close<img src="img/close.png" height="100px" width="100px"></div>
        </div>

        <!-- user register form -->


        <!-- login form -->

    		<!-- background-animation -->

    		<div class = "ball red"></div>
    		<div class = "ball yellow"></div>
    		<div class = "ball orange"></div>
    		<div class = "ball blue"></div>

    		<!-- background-animation -->

    		<div id = "login">
  		    <h1>Bulletin &nbsp;Board</h1>
  		    <form action = "bbs.php" method = "post">
              <div class = "input_wrapper">
                <input class = "input_text" id = "login_name" type = "text" name= "user_name" value = "<?=$user?>" required>
                <label class = "input_label" for="login_name">Enter your name</label>
              </div>
              <div class="input_wrapper">
    		    	  <input class= "input_pass" type = "password" name = "password" value = "" required>
                <label class = "input_label" for="login_name">Enter password</label>
              </div>
    		    	<input type = "submit" value = "login">&nbsp;&nbsp;
    				  <input type = "button" value = "sign up">
  		    </form>

    	<!-- login error report -->

			<?php if($login_error){?>
				   <div class = "login_error error">ユーザー名、若しくはパスワードが間違っています。</div>
			<?php }?>

			<!-- login error report -->

      <!-- register error report -->

      <?php if($register_error){?>
           <div class = "register_error error">そのユーザー名は既に登録されています。</div>
      <?php }?>

      <!-- register error report -->

    		</div>
    	<!-- login form -->

      <!-- animation JavaScript -->

			<script type = "text/javascript" src = "js/ballAnimation.js"></script>
      <script type = "text/javascript" src = "js/buttonAnimation.js"></script>

			<!-- animation JavaScript -->

      <script type="text/javascript" src="js/passCheck.js"></script>
      <script type="text/javascript">
        $('div.close_pane').on('click',function(){
          $('div#user_register_form').removeClass('appear');
        });
      </script>

    		<!-- bbs main page -->

    		<?php }else{?>

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
          try {
              $threads = db_access("bbs","SELECT threads.id as thread_id,title, threads.date, users.name as user_name,description,threads.posts_num FROM threads INNER JOIN users on threads.user_id = users.id ");
          } catch (\Exception $e) {

          }
        ?>
        <div class="thread" name="create" title="create new thread !!">
          <div class="Ttitle">Create New Thread</div>
          <img src="img/add.svg" height="65px" width="65px">
        </div>


        <?php while ($thread = mysqli_fetch_array($threads)) {
            $thread['description'] = nl2br($thread['description']);
            $thread['description'] = str_replace("\n","",$thread['description']);
          ?>
        <a class="post_link" href="<?php echo "posts.php?thread_id=".$thread['thread_id']; ?>" target="_blank">
          <div class="thread">
            <div class="Ttitle"><?=$thread['title']  ?></div>
            <div class="Tuser">Create by <?=$thread['user_name']  ?></div>
            <div class="Tdate">Last post : <?=$thread['date']  ?></div>
            <div class="Tposts">Total : <?=$thread['posts_num']  ?>Posts</div>
            <div class="Tdescription"><?=$thread['description']  ?></div>
          </div>
        </a>
        <?php } ?>

        <div class="wrapper"></div>
        <script type="text/javascript" src="js/createThreadForm.js"></script>
        <script type="text/javascript">
          $('div.logout').on('click',function(){
            window.location.href = "logout.php";
          })
        </script>
      <?php }?>
    		</div>

    		<!-- bbs main page -->

        </body>
    </html>
