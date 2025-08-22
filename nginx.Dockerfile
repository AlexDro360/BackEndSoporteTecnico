FROM nginx:alpine
COPY nginx-backend.conf /etc/nginx/conf.d/default.conf
COPY . /var/www
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
