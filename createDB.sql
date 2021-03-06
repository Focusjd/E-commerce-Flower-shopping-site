
create database flowerDB;
use flowerDB;
create table users(
                      user_id int primary key auto_increment,
                      userName char (40) not null unique,
                      password char (40) not null,
                      user_address char(200) null,
                      userEmail char(40) null
);
create table admin(
                      user_id int primary key auto_increment,
                      userName char (40) not null unique,
                      password char (40) not null
);

create table category(
                         category_id int primary key auto_increment,
                         category_name char(20) not null
);

create table product(
                        product_id int primary key auto_increment,
                        product_name char (100) not null,
                        category_id int not null,
                        product_title char (30),
                        product_intro text ,
                        product_picture char (200),
                        product_price double,
                        product_selling_price double ,
                        product_num int,
                        product_sales int,
                        constraint FK_product_category foreign key (category_id) references category (category_id)
);
-- create table product_picture(
--                                 id int primary key auto_increment,
--                                 product_id int not null,
--                                 product_picture char (200),
--                                 intro text null,
--                                 constraint FK_product_id foreign key (product_id) references product (product_id)
-- );
create table shoppingCart(
                             id int primary key auto_increment,
                             user_id int not null,
                             product_id int not null,
                             num int not null,
                             constraint FK_user_id foreign key (user_id) references users (user_id),
                             constraint FK_shoppingCart_id foreign key (product_id) references product (product_id)
);
create table orders(
                       id int primary key auto_increment,
                       order_id bigint not null,
                       user_id int not null,
                       product_id int not null,
                       product_num int,
                       product_price double,
                       order_time bigint not null,
                       shipping_info char (100),
                       payment_info char (100),
                       constraint FK_order_user_id foreign key (user_id) references users (user_id),
                       constraint FK_order_id foreign key (product_id) references product (product_id)
);
create table collect(
                        id int primary key auto_increment,
                        user_id int not null,
                        product_id int not null,
                        collect_time bigint not null,
                        constraint FK_collect_user_id foreign key (user_id) references users (user_id),
                        constraint FK_collect_id foreign key (product_id) references product (product_id)
);
INSERT INTO admin values ("1", "admin", "admin");
