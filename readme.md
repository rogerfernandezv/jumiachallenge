<p align="center"><img src="https://ng.jumia.is/cms/jumialogonew.png"></p>

## About

Jumia Challenge

## Install(Local server)

```bash
# clone repository
git clone https://github.com/rogerfernandezv/jumiachallenge

# go to folder
cd jumiachallenge

# install dependencies
composer install

# to testing using php builtin server
php -S 0.0.0.0:8080 -t public/

```
## Install(Docker)

```bash
# clone repository
git clone https://github.com/rogerfernandezv/jumiachallenge

# create container
docker build -f ./Dockerfile -t jumia/jumiachallenge .

# execute container
docker run -itd --rm -v `pwd`:/var/www/jumia -p 9008:80 --name jumiachallenge.local jumia/jumiachallenge:latest

```

# Testing
```bash
# Phpunit
composer test

```

## Licença

The JumiaChallenge is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
