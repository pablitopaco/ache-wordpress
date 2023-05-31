# Imagem base
FROM wordpress:latest

# Copiar o arquivo .env para o diretório do tema
COPY .env /var/www/html/

# Diretório de trabalho
WORKDIR /var/www/html/wp-content/themes/my-theme

# Copiar arquivos do tema
COPY . .

# Instalar dependências do tema (se necessário)
# RUN npm install

# Instalar pacotes PHP necessários
RUN apt-get update && apt-get install -y --no-install-recommends \
    php-xml \
    php-zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Carregar variáveis de ambiente do arquivo .env usando o dotenv
CMD ["sh", "-c", "php -d variables_order=EGPCS -S 0.0.0.0:80 -t . -d display_errors=1 -d error_reporting=E_ALL && apache2-foreground"]