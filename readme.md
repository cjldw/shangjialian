# 我要联赢 商家恋

## 本地部署

1. 直接克隆项目到本地(由于考虑本地没有安装composer, 故把vendor里所有的文件压缩都提交了)

    ```bash
        git clone https://github.com/vvotm/shangjialian.git
    ```
2. 进入到项目目录, 解压vendor.zip文件. 文件结构为:

    ```bash
        _
        |-app
        |-public
        |-..
        |-vendor
          |-bin
          |-composer
          |-..
    ```


2. 导入数据库

  - [ ] 登入mysql客户端执行

      ```bash
        source /you/clone/path/shangjialian/document/database.sql
      ```
  - [ ] 如果已将安装mysql管理工具(navicat, sqlyog)等, 直接导入sql文件即可

3. 配置虚拟主机

  - apache, 直接找到对应的安装目录, 招到http-vhosts.conf 复制一段, **document /you/clone/path/shangjialian/public**即可

  - nginx, 直接贴出, 修改对应注视地方即可. **确保此server段被加载到nginx主配置文件中**

    ```bash
      server {
          listen 80;
          #@修改 自定义本地访问域名
          server_name shangjialian.dev;
          #@修改 项目目录
          root D:/your/clone/path/shangjialian/public/;
          index index.html index.htm index.php;
          charset utf-8;
          location / {
              try_files $uri $uri/ /index.php$is_args$args;
          }
          
          location = /favicon.ico { access_log off; log_not_found off; }
          location = /robots.txt  { access_log off; log_not_found off; }
          # access_log off;
          error_log  logs/shangjialian-dev.log error;
          sendfile on;
          client_max_body_size 100m;
          autoindex on;

          location ~ \.php$ {
              fastcgi_split_path_info ^(.+\.php)(/.+)$;
              @修改 确保本地php-fpm启动并监听在9000端口, 不是默认的, 修改对应的端口即可
              fastcgi_pass 127.0.0.1:9000;
              fastcgi_index index.php;
              fastcgi_param   APP_ENV dev;
              include fastcgi_params;
              fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
              fastcgi_intercept_errors off;
              fastcgi_buffer_size 16k;
              fastcgi_buffers 4 16k;
          }

          location ~ /\.ht {
              deny all;
          }
      }
    ```

4. 在hosts文件中添加对应域名映射. 可以使用hosts管理工具(switchHost)方便修改.

5. 重启apache或nginx, 打开浏览器, 访问对应地址.

6. 默认后台地址为 `http://your-setup-domain/admin`, 用户名: `admin`, 密码: `admin123;`




