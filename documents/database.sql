-- 创建数据库 
create database if not exists shangjialian charset utf8;

-- 选择数据库
use shangjialian;

-- 后台用户登录表
create table  if not exists bizman_pc_users (
  id int unsigned auto_increment,
  name varchar(32) not null default '' comment '后台登录名称',
  password char(32) not null default '' comment '用户密码',
  remember_token char(100) null default null '' comment 'api调用需要字段',
  salt char(4) not null default 'abcd' comment '密码加盐',

  created_at datetime null default current_timestamp,
  updated_at datetime null default null,
  deleted_at datetime null default null,

  primary  key (id),
  unique key index_name (name)
) engine innodb charset utf8;

-- 默认登入
insert into bizman_pc_users (name, password, salt) values ("admin", md5("admin123;#1bc"), '#1bc');

-- 行业表
create table if not exists bizman_industry (
    id int unsigned auto_increment,
    name varchar(32) null default null comment "行业名称",
    parent_id int unsigned not null default 0 comment "子类名称",

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_parent_id (parent_id)
) engine innodb charset utf8;

-- 行业表默认指
insert into bizman_industry (name) values ("教育培训"), ("运动健身"), ("美容美体"), ("婚庆礼仪"), ("医疗保健"), ("文化旅游"), ("餐饮美食"), ("批发零售"), ("家居装修"), ("汽车地产"), ("金融保险"), ("休闲娱乐");

 -- 活动表
create table if not exists bizman_activity (
    id int unsigned auto_increment,
    title varchar(64) not null default "" comment "活动名称",
    industry_id tinyint unsigned not null default 0 comment "行业id",
    description varchar(100) not null default "" comment "活动简介",
    keyword varchar(4) not null default "" comment "已经收集字符",
    cover_img varchar(256) null default null comment "封面图片",
    banner_img varchar(256) null default null comment "活动内页图片",
    color_plate varchar(512) null default null comment "活动背景等调色板",
    background_music varchar(256) null default null comment "背景音乐",
    is_recommend tinyint unsigned not null default 0 comment "活动推荐, [0/普通, 1/推荐]",
    is_offshelf tinyint unsigned not null default 0 comment "活动是否下架,[0/正常, 1/下架]",
    bizman_copy_cnt int unsigned not null default 0 comment "商家使用次数",
    netizen_copy_cnt int unsigned not null default 0 comment "网名转发分享次数",

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_title (title),
    key index_is_recommend (is_recommend),
    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)

) engine innodb charset utf8;

-- 客户表 --
create table if not exists bizman_user (
    id int unsigned auto_increment,
    mobile varchar(16) not null default "" comment "用户手机号码",
    name varchar(16) not null default "" comment "用户姓名",
    password varchar(32) null default null comment "用户密码",
    salt middleint not null default "0" comment "密码加盐",
    login_cnt int unsigned not null default 0 comment "用户登入次数",

    apply_at datetime null default null comment "用户开通时间",
    expired_at datetime null default null comment "用户过期时间",

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key index_id (id),
    key index_name (name),
    key index_apply_at (apply_at),
    key index_expired_at (expired_at),

    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)
) engine innodb charset utf8;

-- 日志表
create table if not exists bizman_recharge_log (
    id int unsigned auto_increment,
    who varchar(32) not null default "" comment "谁",
    what varchar(1024) not null default "" comment "做了什么",
    log_type tinyint unsigned not null default 0 comment "类别, 保留字段",

    primary key (id),
    key index_log_type (log_type)
) engine innodb charset utf8;

