FROM nginx:1.13.7

ADD config/vhost.conf /etc/nginx/conf.d/default.conf
