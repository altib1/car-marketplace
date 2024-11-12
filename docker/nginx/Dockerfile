FROM nginx:latest

# Copy custom Nginx configuration file
COPY default.conf /etc/nginx/conf.d/default.conf

# Copy the snippets directory
COPY snippets /etc/nginx/snippets

# Set working directory
WORKDIR /var/www/html

EXPOSE 80
