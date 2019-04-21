# Debian
FROM debian:jessie

# Maintainer
MAINTAINER Roger Fernandez

# Environment variable
ENV SRV_DNS=jumia.local

# Updating repository
RUN printf "deb http://archive.debian.org/debian/ jessie main\ndeb-src http://archive.debian.org/debian/ jessie main\ndeb http://security.debian.org jessie/updates main\ndeb-src http://security.debian.org jessie/updates main" > /etc/apt/sources.list

# Update utils
RUN apt-get update \
	&& apt-get install -y  \
	vim \
	curl \
	wget

# Install PHP 7.1
RUN apt-get install -y apt-transport-https lsb-release ca-certificates  \
	&& wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
	&& echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
	&& apt-get update \
	&& apt-get install -y php7.1

# Install PHP modules
RUN apt-get install -y \
	php7.1-curl \
	php7.1-xml \
	php7.1-gd \
	php7.1-intl \
	php7.1-mysqli \
	php7.1-zip \
	php7.1-dom \
	php7.1-mbstring \
	php7.1-dev \
	php7.1-sqlite3 \
    php-pear

RUN phpenmod curl \
	&& phpenmod xml \
	&& phpenmod gd \
	&& phpenmod intl \
	&& phpenmod mysqli \
	&& phpenmod zip \
	&& phpenmod dom \
	&& phpenmod mbstring \
	&& phpenmod sqlite3

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php composer-setup.php  --quiet --install-dir=/usr/bin/ --filename=composer \
	&& php -r "unlink('composer-setup.php');"

# Install Apache 2
RUN apt-get install -y apache2 apache2-doc apache2-utils libapache2-mod-php7.1

# Setup virtual host
RUN echo "<VirtualHost *:80 *:9007>" >> /etc/apache2/sites-available/jumia.conf \
	&& echo "	DocumentRoot \"/var/www/jumia/public\"" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "	ServerAdmin rogerfernandez@it.com.br" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "	ServerName "$SRV_DNS >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "	<Directory \"/var/www/jumia/public\">" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "		AllowOverride All" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "		Order allow,deny" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "		Allow from all" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "		Require all granted" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "	</Directory>" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "	ErrorLog \${APACHE_LOG_DIR}/jumia.error.log" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "	CustomLog \${APACHE_LOG_DIR}/jumia.access.log combined" >>  /etc/apache2/sites-available/jumia.conf \
	&& echo "</VirtualHost>" >>  /etc/apache2/sites-available/jumia.conf \
	&& a2ensite jumia.conf \
	&& a2dissite 000-default.conf \
	&& echo "127.0.0.1	"$SRV_DNS >> /etc/hosts \
    && echo "::1	"$SRV_DNS >> /etc/hosts

# Ativar PHP
RUN a2enmod rewrite \
	&& a2enmod php7.1

# Copiar os arquivos da API
COPY ./ /var/www/jumia

# Rodar Apache
ENTRYPOINT ["/usr/sbin/apache2ctl","-DFOREGROUND"]

# Pasta de trabalho
WORKDIR "/var/www/jumia"
