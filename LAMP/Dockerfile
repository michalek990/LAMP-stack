FROM php:7.4-apache

# Skopiuj pliki aplikacji do katalogu domyślnego serwera Apache
COPY . /var/www/html/

# Ustaw właściwe uprawnienia
RUN chown -R www-data:www-data /var/www/html

# Włącz moduł Apache mod_rewrite
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
