-- 创建数据库 
create database if not exists shangjialian charset utf8;

-- 选择数据库
use shangjialian;

-- 后台用户登录表
create table  if not exists bizman_pc_users (
    id int unsigned auto_increment,
    name varchar(32) not null default '' comment '后台登录名称',
    password char(32) not null default '' comment '用户密码',
    remember_token char(100) null default null  comment 'api调用需要字段',
    salt char(4) not null default 'abcd' comment '密码加盐',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary  key (id),
    unique key index_name (name),
    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)
) engine innodb charset utf8;

-- 默认登入
insert into bizman_pc_users (name, password, salt) values ('admin', md5('admin123;#1bc'), '#1bc');

-- 行业表
create table if not exists bizman_industry (
    id int unsigned auto_increment,
    name varchar(32) null default null comment '行业名称',
    parent_id int unsigned not null default 0 comment '子类名称',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_parent_id (parent_id),
    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)
) engine innodb charset utf8 comment '行业类别表';

-- 行业表默认指
insert into bizman_industry (name) values ('教育培训'), ('运动健身'), ('美容美体'), ('婚庆礼仪'), ('医疗保健'), ('文化旅游'), ('餐饮美食'), ('批发零售'), ('家居装修'), ('汽车地产'), ('金融保险'), ('休闲娱乐');

-- 活动模板表
create table if not exists bizman_activity_template (
    id int unsigned auto_increment,
    title varchar(64) not null default '' comment '活动名称',
    industry_id tinyint unsigned not null default 0 comment '行业id',
    description varchar(100) not null default '' comment '活动简介',
    cover_img varchar(256) null default null comment '封面图片',
    banner_img varchar(256) null default null comment '活动内页图片',
    color_plate varchar(512) null default null comment '活动背景等调色板',
    background_music varchar(256) null default null comment '背景音乐',

    act_start_time date null default null comment '活动开始时间',
    act_end_time date null default null comment '活动结束时间',
    act_prize_name varchar(32) null default null comment '奖品名称',
    act_prize_cnt int unsigned not null default 0 comment '活动奖品数量',
    prize_decorate varchar(16) null default null comment '奖品前部分修饰',
    act_prize_unit varchar(4) null default null comment '奖品单位',
    act_prize_desc varchar(512) null default null comment '奖品描述',
    act_rule_decorate varchar(16) null default null comment '活动前缀修饰',
    act_rule_cnt int unsigned not null default 0 comment '活动规则数量',
    act_rule_keywords varchar(16) null default '收集' comment '参与活动动作, [元宝, 星星啥的]',

    act_images varchar(1024) null default null comment '图片序列化地址, 最多5张',

    organizer_name varchar(32)  null default null comment '主办方姓名',
    organizer_address varchar(32) null default null comment '主办方地址',
    organizer_phone varchar(16) null default null comment '主办方电话',

    about_us varchar(512) null default null comment '关于我们',
    video_url varchar(256) null default null comment '视频地址',
    link_name varchar(64) null default null comment '连接名称',
    link_url varchar(256) null default null comment '连接地址',
    act_type tinyint unsigned not null default 1 comment '[1/普通活动, 2/保留]',

    is_recommend tinyint unsigned not null default 0 comment '活动推荐, [0/普通, 1/推荐]',
    is_offshelf tinyint unsigned not null default 0 comment '活动是否下架,[0/正常, 1/下架]',
    bizman_copy_cnt int unsigned not null default 0 comment '商家使用次数',
    netizen_copy_cnt int unsigned not null default 0 comment '网名转发分享次数',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_title (title),
    key index_act_start_time (act_start_time),
    key index_act_end_time (act_end_time),
    key index_act_type (act_type),
    key index_is_recommend (is_recommend),
    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)

) engine innodb charset utf8 comment '活动模板表';

-- 插入默认数据
insert into `bizman_activity_template` (`id`, `title`, `industry_id`, `description`, `cover_img`, `banner_img`, `color_plate`, `background_music`, `act_start_time`, `act_end_time`, `act_prize_name`, `act_prize_cnt`, `prize_decorate`, `act_prize_unit`, `act_prize_desc`, `act_rule_decorate`, `act_rule_cnt`, `act_rule_keywords`, `act_images`, `organizer_name`, `organizer_address`, `organizer_phone`, `about_us`, `video_url`, `link_name`, `link_url`, `act_type`, `is_recommend`, `is_offshelf`, `bizman_copy_cnt`, `netizen_copy_cnt`, `created_at`, `updated_at`, `deleted_at`) values
    (1, '不错的活动', 2, '这是一个不错的活动', 'http://bpic.588ku.com/back_pic/04/11/76/05581ad01da2a8d.jpg', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', '#000000', null, '2017-02-18 00:00:00', '2017-03-21 00:00:00', '科比亲笔签名篮球', 1000, 'dayouh', '篮球', '科比亲笔签名篮球', '快抢', 100, '云豹', '[\'http://s.51lianying.com/images/biz/common/biz_person_head.jpg\']', '罗大文', '天堂路282好', '13211112222', '我们是我要联赢', 'http://youku.com/2323.mp4', 'baidu', 'http://www.baidu.com', 1, 1, 1, 0, 0, '2017-03-08 13:20:22', '2017-03-10 00:05:43', null),
    (2, '非常好的活动', 1, '非常好的活动', 'http://bpic.588ku.com/back_pic/04/11/76/05581ad01da2a8d.jpg', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', '#ccc', null, '2017-02-18 00:00:00', '2019-03-21 00:00:00', '苏泊尔套装', 300, '送完就没有', '套', '苏泊尔超级电饭煲+电磁炉+美的中央空调', '快抢', 200, '收集', '[\'http://s.51lianying.com/images/biz/common/biz_person_head.jpg\']', '大帝', '莫干山路128号', '13211112222', '我们是我要联赢', 'http://youku.com/2323.mp4', null, null, 1, 0, 0, 0, 0, '2017-03-13 20:28:28', null, null),
    (3, '情人节活动', 4, '情人节活动', 'http://bpic.588ku.com/back_pic/04/11/76/05581ad01da2a8d.jpg', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', '#ccc', null, '2017-02-18 00:00:00', '2019-03-21 00:00:00', '蛋糕', 1999, null, '份', '托马斯物理教科书', '快抢', 400, '收集', '[\'http://s.51lianying.com/images/biz/common/biz_person_head.jpg\']', '边哥', '万塘路252号', '13211112222', '我们是我要联赢', 'http://youku.com/2323.mp4', null, null, 1, 0, 0, 0, 0, '2017-03-13 20:28:39', null, null);



-- 活动排行表
create table if not exists bizman_activity_rank (
    id int unsigned auto_increment,
    act_id int unsigned not null default 0 comment '活动id, 为0时候, 为默认数据',
    merchant_id int unsigned not null default 0 comment '商家id',
    openid char(28) null default null comment '用户opend_id',
    name varchar(64) null default null comment '参与者名称',
    phone varchar(16) null default null comment '商家手机号码',
    spend_time varchar(32) not null default '还差一点点',
    join_cnt int unsigned not null default 0 comment '参与次数',
    completed_cnt int unsigned not null default 0 comment '完成次数',
    level tinyint unsigned not null default 0 comment  '级别, [0/制作者分享出来 1/网名点击我要玩出来的]',
    helpers text null default null comment '帮手列表集合， json序列化',
    is_completed tinyint unsigned not null default 0 comment '是否完成[0/未完成, 1/已经完成]',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    unique key index_act_openid (act_id, openid),
    key index_deleted_at (deleted_at)

) engine innodb charset utf8 comment '活动排行表';

insert into bizman_activity_rank (act_id, name, spend_time, is_completed) values
    (0, '罗至东', '16', 1), (0, '张伟', '12', 0), (0, '李国资', '12', 1), (0, '王建国', '12', 1),
    (0, '李志宏', '23', 1), (0, '高晓峰', '12', 0), (0, '李晓峰', '12', 0), (0, '武大伟', '12', 1),
    (0, '向志华', '19', 1), (0, '张志东', '12', 0), (0, '陈志新', '12', 0), (0, '张小凡', '12', 0),
    (0, '吴迪', '12', 0), (0, '钱峰', '12', 0), (0, '陈浩', '12', 0), (0, '王宝剑', '12', 1),
    (0, '肖芬', '12', 0), (0, '孙小根', '12', 0), (0, '康祥可', '12', 0), (0, '赵小兰', '12', 0);

-- 日志表
create table if not exists bizman_recharge_log (
    id int unsigned auto_increment,
    who varchar(32) not null default '' comment '谁',
    what varchar(1024) not null default '' comment '做了什么',
    log_type tinyint unsigned not null default 0 comment '类别, 保留字段',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_log_type (log_type),

    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)

) engine innodb charset utf8 comment '充值表';


-- 商家表
create table if not exists bizman_merchant (
    id int unsigned auto_increment,
    openid char(28) not null default '' comment '用户opend_id',
    name varchar(32) not null default '' comment '商家名称',
    salt char(6) not null default 'abcdef' comment '密码加盐',
    password varchar(32) not null default '' comment '用户登入密码',
    remember_token char(100) null default null  comment 'api调用需要字段',
    phone varchar(16) null default null comment '商家手机号码',
    login_cnt int unsigned not null default 0 comment '用户登入次数',
    charged_at datetime null default now() comment '用户充值时间',
    expired_at datetime null default null comment '用户到期时间',
    is_expired tinyint unsigned not null default 0 comment '是否过期[0/未过期, 1/已经过期]',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    unique key index_openid (openid),
    unique key index_phone (phone),
    key index_charged_at (charged_at),
    key index_expired_at (expired_at),
    key index_is_expired (is_expired),
    key index_created_at (created_at),
    key index_updated_at (updated_at),
    key index_deleted_at (deleted_at)
) engine innodb charset utf8 comment '商家表';

insert into `bizman_merchant` values ('7', 'abcdefiok-wefladf-edgo1p', 'luowen', '112194', 'e213114c19a123d8f5d2b04e87875515', null, '13211112222', '45', '2017-03-23 21:03:22', null, '0', '2017-03-23 21:03:22', '2017-03-26 10:32:54', null);


-- 首页搭建表
create table if not exists bizman_mobile_skeleton (
    id int unsigned auto_increment,
    banner_url varchar(256) not null default '' comment '首页搭建广告图',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)
) engine innodb charset utf8 comment '商家恋首页图设置';

-- 默认背景图
insert into bizman_mobile_skeleton (banner_url) values ('http://bpic.588ku.com/back_pic/04/11/76/05581ad01da2a8d.jpg');

-- 商家用户复制木板后, 新建自己活动表
create table if not exists bizman_merchant_acts (
    id int unsigned auto_increment,
    merchant_id int unsigned not null default 0 comment '关联商家id',
    openid char(28) not null default '' comment '关联用户opend_id',
    title varchar(64) not null default '' comment '活动名称',
    industry_id tinyint unsigned not null default 0 comment '行业id',
    description varchar(100) not null default '' comment '活动简介',
    cover_img varchar(256) null default null comment '封面图片',
    banner_img varchar(256) null default null comment '活动内页图片',
    color_plate varchar(512) null default null comment '活动背景等调色板',
    background_music varchar(256) null default null comment '背景音乐',

    act_start_time date null default null comment '活动开始时间',
    act_end_time date null default null comment '活动结束时间',
    act_prize_name varchar(32) null default null comment '奖品名称',
    act_prize_cnt int unsigned not null default 0 comment '活动奖品数量',
    prize_decorate varchar(16) null default null comment '奖品前部分修饰',
    act_prize_unit varchar(4) null default null comment '奖品单位',
    act_prize_desc varchar(512) null default null comment '奖品描述',
    act_rule_decorate varchar(16) null default null comment '活动前缀修饰',
    act_rule_cnt int unsigned not null default 0 comment '活动奖品数量',
    act_rule_keywords varchar(16) null default '收集' comment '参与活动动作, [元宝, 星星啥的]',

    act_images varchar(1024) null default null comment '图片序列化地址, 最多5张',

    organizer_name varchar(32)  null default null comment '主办方姓名',
    organizer_address varchar(32) null default null comment '主办方地址',
    organizer_phone varchar(16) null default null comment '主办方电话',

    about_us varchar(512) null default null comment '关于我们',
    video_url varchar(256) null default null comment '视频地址',
    link_name varchar(64) null default null comment '连接名称',
    link_url varchar(256) null default null comment '连接地址',
    act_type tinyint unsigned not null default 1 comment '[1/普通活动, 2/保留]',

    is_recommend tinyint unsigned not null default 0 comment '活动推荐, [0/普通, 1/推荐]',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_title (title),
    key index_act_start_time (act_start_time),
    key index_act_end_time (act_end_time),
    key index_act_type (act_type),
    key index_is_recommend (is_recommend),
    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)


) engine innodb charset utf8 comment '商家制作表';

insert into `bizman_merchant_acts` values ('1', '0', 'abcdefiok-wefladf-edgo1p', '疯狂夺宝', '0', '新的一年来临了，快来抢个新年币增加好运吧，抢到足够新年币，即可兑换好礼。', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', '#ccc', null, null, null, null, '0', null, null, null, null, '0', '收集', null, null, null, null, null, null, null, null, '1', '0', '2017-03-23 21:03:22', '2017-03-25 13:53:33', null);
insert into `bizman_merchant_acts` values ('2', '7', 'abcdefiok-wefladf-edgo1p', '疯狂夺宝', '0', '新的一年来临了，快来抢个新年币增加好运吧，抢到足够新年币，即可兑换好礼。', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', '#ccc', null, '2017-03-14 09:33:34', '2017-04-09 09:34:02', '[九阳]浆机哈哈', '1', null, null, null, null, '0', '收集', null, null, null, null, null, null, null, null, '1', '0', '2017-03-25 14:04:35', '2017-03-25 14:04:35', null);
insert into `bizman_merchant_acts` values ('4', '7', 'abcdefiok-wefladf-edgo1p', '圣诞卡uial', '0', '新的一年来临了，快来抢个新年币增加好运吧，抢到足够新年币，即可兑换好礼。', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', '#ccc', null, '2017-03-08 09:34:18', '2017-03-26 09:34:23', '四件套', '44', null, null, null, null, '0', '收集', null, null, null, null, null, null, null, null, '1', '0', '2017-03-26 09:32:22', null, null);
insert into `bizman_merchant_acts` values ('6', '7', 'abcdefiok-wefladf-edgo1p', '水星家纺换购', '0', '新的一年来临了，快来抢个新年币增加好运吧，抢到足够新年币，即可兑换好礼。', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', 'http://s.51lianying.com/images/www/index_v2/thum-1.jpg', '#ccc', null, '2017-04-09 09:34:18', '2017-03-26 09:34:23', '四件套', '4', null, '件', '正品水星家纺四件套', null, '0', '换购', null, null, null, null, null, null, null, null, '1', '0', '2017-03-26 12:32:15', null, null);


-- 用户参与表
create table if not exists bizman_visit_log (
    id int unsigned auto_increment,
    merchant_id int unsigned not null default 0 comment '来访是那个商家制作的活动',
    openid char(28) not null default '' comment '关联用户opend_id',
    act_id int unsigned not null default 0 comment '来访用户查看的是那个活动',

    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null,

    primary key (id),
    key index_merchant_id (merchant_id),
    key index_open_id (openid),
    key index_act_id (act_id),
    key index_created_at(created_at),
    key index_updated_at(updated_at),
    key index_deleted_at(deleted_at)
) engine innodb charset utf8 comment '用户来访记录表';


-- 是否支持表
create table if not exists bizman_supported (
    id int unsigned auto_increment,
    act_id int unsigned not null default 0 comment '活动id',
    owner_openid char(28) not null default '' comment '平台opend_id',
    support_openid char(28) not null default '' comment 'opend_id检测',

    primary key (id),
    unique key index_supported (act_id, owner_openid, support_openid),
    created_at datetime null default current_timestamp,
    updated_at datetime null default null,
    deleted_at datetime null default null

) engine innodb charset utf8;

