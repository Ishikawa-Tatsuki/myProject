create table
  users(id int unsigned not null auto_increment primary key,
        name varchar(20) not null,
        age int,
        gender char(6),
        adress varchar(30),
        date timestamp,
        e_mail varchar(30),
        posts_num int default 0 not null,
        img mediumblob,
        is_admin boolean not null default false,
        password verchar(30) not null,
        threads_num int defailt 0);
create table
  threads(id int unsigned not null auto_increment primary key,
          title varchar(30) not null,
          date timestamp,
          user_id int unsigned not null,
          description text,
          posts_num int default 0,
          is_requested boolean not null default false,
          foreign key(user_id) references users(id)
          );
create table
  posts(id int unsigned not null auto_increment,
        date timestamp,
        title varchar(30) not null,
        content text,
        thread_id int unsigned not null,
        user_id int unsigned not null,
        foreign key(thread_id) references threads(id),
        foreign key(user_id) references users(id),
        primary key(id,thread_id)
        );

drop procedure if exists add_threads_post_num;

delimiter $$
create procedure add_threads_post_num(IN $id int)
  main:begin

       update threads set posts_num = posts_num + 1 where threads.id = $id;

       end;

$$
delimiter ;

drop procedure if exists add_users_post_num;

delimiter $$
create procedure add_users_post_num(IN $id int)
  main:begin

       update users set posts_num = posts_num + 1 where users.id = $id;

       end;

$$
delimiter ;

drop procedure if exists reduce_threads_post_num;

delimiter $$
create procedure reduce_threads_post_num(IN $id int)
  main:begin

       update threads set posts_num = posts_num - 1 where threads.id = $id;

       end;

$$
delimiter ;

drop procedure if exists reduce_users_post_num;

delimiter $$
create procedure reduce_users_post_num(IN $id int)
  main:begin

       update users set posts_num = posts_num - 1 where users.id = $id;

       end;

$$
delimiter ;

drop trigger if exists add_post;

delimiter $$
create trigger add_post after insert on posts for each row
  begin
        call add_users_post_num(NEW.user_id);
        call add_threads_post_num(NEW.thread_id);
  end;
  $$

delimiter ;

drop trigger if exists reduce_post;

delimiter $$
create trigger reduce_post after delete on posts for each row
  begin
        call reduce_users_post_num(OLD.user_id);
        call reduce_threads_post_num(OLD.thread_id);
  end;
  $$

delimiter ;

drop procedure if exists add_users_thread_num;

delimiter $$
create procedure add_users_thread_num(IN $id int)
  main:begin

       update users set threads_num = threads_num + 1 where users.id = $id;

       end;

$$
delimiter ;
drop procedure if exists reduce_users_thread_num;

delimiter $$
create procedure reduce_users_thread_num(IN $id int)
  main:begin

       update users set threads_num = threads_num - 1 where users.id = $id;

       end;

$$
delimiter ;

drop trigger if exists add_thread;

delimiter $$
create trigger add_thread after insert on threads for each row
  begin
        call add_users_thread_num(NEW.user_id);
  end;
  $$

delimiter ;

drop trigger if exists reduce_thread;

delimiter $$
create trigger reduce_thread after delete on threads for each row
  begin
        call reduce_users_thread_num(OLD.user_id);
  end;
  $$

delimiter ;
