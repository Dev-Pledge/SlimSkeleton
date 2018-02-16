# Slim Framework 3 Skeleton Application For DevPledge

This is based on slim/slim-skeleton from Josh Lockhart.

This also has Our Docker Compose and Base Dockerfiles included!

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    composer create-project dev-pledge/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To set up sentry

    docker-compose run --rm sentry upgrade

To run the application in development, you can also run either of these command. 

	docker-compose up

or

    composer start-docker
    
    gem install docker-sync
    
    docker-sync up
    
Run this command to run the test suite

	composer test

To resolve to the correct domain you want to use

change files:

vars inside [] are to be changed if needed!
    
    config/swoolehost.conf
    
        server{
            listen 80;
            listen [::]:80;
            listen 443;
            listen [::]:443;
        
            server_name [api.swoole.co.uk];
        
            location /
            {
                proxy_pass http://[api:9501];
            }
        }
        
    config/webhost.conf
        server {
            listen 80;
            listen 443;
            index index.php index.html;
            root /var/www/public;
        
            server_name [api.web.co.uk];
        
            location / {
                try_files $uri /index.php?$args;
            }
        
            location ~ \.php$ {
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass [api:9000];
                fastcgi_index index.php;
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_param PATH_INFO $fastcgi_path_info;
            }
        }
        
    .developmentenv
        
        MYSQL_HOST="[mysql-db]"
        MYSQL_DB="devpledge"
        MYSQL_USER="root"
        MYSQL_PASSWORD="test_pass"
        JWT_SECRET="987ytgvbnytfcvbh4g3uwsjdcnfbr"
        SWOOLE_PORT="[9501]"
        API_DOMAIN="[api]"
        
    docker-compose.yml
    
        version: "3"
        
        services:
          [api]:
            build:
              context: .
              dockerfile: api.dockerfile
            environment:
              docker: "true"
              production: "false"
            volumes:
              - .:/var/www
              - ./logs:/var/www/logs
            ports:
              - 9000:9000
              - [9501:9501]
        
          web:
            build:
              context: .
              dockerfile: web.dockerfile
            volumes:
              - ./config:/etc/nginx/conf.d
            ports:
              - 80:80
              - 443:443
        
          [mysql-db]:
            restart: always
            image: mysql:latest
            environment:
              MYSQL_ROOT_PASSWORD: 'test_pass'
              MYSQL_USER: 'test'
              MYSQL_PASS: 'pass'
            volumes:
             - ./data:/var/lib/mysql
            ports:
              - [3307:3306]
    
    /etc/hosts (access by sudo nano /etc/hosts) 
    
        #add lines so your broswer resolves to correct domains on your MAC or Dev Machine
        127.0.0.1       [api.web.co.uk]
        127.0.0.1       [api.swoole.co.uk]

That's it! Now go build something cool.

This needs some work before this could go to PRODUCTION proper - but it will get you developing!
