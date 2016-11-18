
alter table tbl_inv_category add urut int default 0

Create table tbl_inv_category_sub (
    id_sub_category int auto_increment,
    name_sub_category varchar(100) default '',
    urut int default 0,
    cat_id int default 0,
    sub_category_create_by varchar(100) default '',
    sub_category_create_date datetime,
    sub_category_edit_by varchar(100) default '',
    sub_category_edit_date datetime

)

Alter table  tbl_inv_product_master add product_sub_category_id int
Alter table  tbl_inv_product_master add featured int


Create table tbl_slider(
    id_slider int auto_increment,
    kode_slider varchar(5) ,
    name varchar(100),
    filename varchar(200),
    link text,
    slider_create_date datetime,
    slider_create_by int,
    slider_update_date datetime,
    slider_update_by int,
    primary key(id_slider)
   
)

Create table tbl_banner
(
    id_banner int auto_increment,
    kode_banner varchar(5) ,
    name varchar(100),
    filename varchar(200),
    link text,
    banner_create_date datetime,
    banner_create_by int,
    banner_update_date datetime,
    banner_update_by int,
    primary key(id_banner)
)