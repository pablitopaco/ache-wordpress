# Use a imagem base do WordPress
FROM wordpress:latest

COPY . /var/www/html/wp-content/themes/ache-theme

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["apache2-foreground"]
