# Dockerfile para el servicio de WordPress
FROM wordpress:latest

# Instalar wp-cli
RUN apt-get update && apt-get install -y \
    less \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/* \
    && curl -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x /usr/local/bin/wp

# Copiar tema personalizado al directorio de temas de WordPress
COPY ./my-theme /var/www/html/wp-content/themes/my-theme

# Dockerfile para el servicio de WordPress

# Cambiar al usuario www-data para ejecutar wp-cli
USER www-data

# Verificar el directorio actual

# Activate the custom theme
# RUN wp theme activate my-theme