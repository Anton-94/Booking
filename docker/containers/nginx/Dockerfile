FROM nginx:latest

WORKDIR /var/www/html

ARG USER_ID
ARG GROUP_ID
RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

COPY ./default.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]
EXPOSE 80