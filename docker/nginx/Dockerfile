FROM nginx:alpine
WORKDIR /var/www
RUN touch var/logs/nginx/error.log
RUN touch var/logs/nginx/access.log
CMD ["nginx"]
EXPOSE ${WEBSERVER_EXPOSED_PORT}