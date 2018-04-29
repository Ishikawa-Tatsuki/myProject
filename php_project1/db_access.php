<?php

function db_access($db,$sql){

    $result = 0;

    $mysqli = new mysqli('localhost','root','root',$db);

    if ($mysqli -> connect_error) {
      echo $mysqli -> connect_error;
      exit();
    }else{
      $mysqli -> set_charset('utf8');
    }

    $result = $mysqli -> query($sql);

    $mysqli -> close();

    return $result;

}

function user_check($user,$pass){

    $flag = false;
    $sql = "SELECT name, password FROM users where users.name = '".$user."' and users.password = '".$pass."'";
    $flag = (db_access('bbs',$sql) -> num_rows === 1);
    return $flag;

}

function get_user_id($user,$pass){

    $sql = "SELECT id FROM users where users.name = '".$user."' and users.password = '".$pass."'";
    $result = mysqli_fetch_array(db_access('bbs',$sql));
    return $result["id"];
}

function get_user_email($user_id){
  $sql = "SELECT e_mail FROM users where users.id = ".$user_id;
  $result = mysqli_fetch_array(db_access('bbs',$sql));
  return $result["e_mail"];
}

?>
