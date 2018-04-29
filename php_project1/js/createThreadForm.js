var heredoc1 = (function () {/*
  <form id="create_thread" action = "insert.php" method = "post">
      <div class="creator_wrapper">作成者 : <span id = "creator"></span></div>
      <table class="post_form">
        <tbody>
          <tr><th>スレッド名　　<input type = "text" name = "title" value = "" required></th></tr>
          <tr><td>スレッドの説明</td></tr>
          <tr>
            <td><textarea cols= "55" rows = "10" wrap = "hard" name = "description" required></textarea><br></td>
          </tr>
          <tr>
            <td>
              <input type = "hidden"  name = "user_id"  value ="">
              <input type = "submit" title = "この内容でスレッドを作成します" value = "スレッドを作成する">
              <input type = "reset" title = "内容をリセットします" value = "内容をリセットする">
            </td>
          </tr>
        </tbody>
      </table>
  </form>
  */}).toString().match(/(?:\/\*(?:[\s\S]*?)\*\/)/).pop().replace(/^\/\*/, "").replace(/\*\/$/, "");
  $('div#main > div.thread[name="create"]').on('click',function(e){
    $('div.wrapper').css({
      height:$('html').height()+"px",
      position:"absolute",
      top:0
    });
  $('div.wrapper').append(heredoc1);
  $('div.wrapper > form#create_thread  input[type="hidden"]').attr({value:user_id});
  $('div.wrapper > form#create_thread  span#creator').text(user_name);
  $('div.wrapper > form#create_thread').on('click',function(e){
    e.stopPropagation();
    });
  });

  $('div.wrapper').on('click',function(){
    $('div.wrapper').css({
      height:0+"px",
      position:"static"
    });
    $('div.wrapper').empty();
  });
