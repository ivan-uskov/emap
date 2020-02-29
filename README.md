# ЭМАП

## Настройка локального окружения

1 - Установить php 7.4, нужно распаковать архив и добавить в path
```
https://windows.php.net/downloads/releases/php-7.4.3-nts-Win32-vc15-x64.zip
```
Так же нужно переименовать php.ini-development в php.ini, и раскомментировать extension=pdo_mysql

2 - Установить composer 
```
https://getcomposer.org/Composer-Setup.exe
```
3 - Установить symfony
```
https://get.symfony.com/cli/setup.exe
```
4 - Установить MySql 5.7, добавить файл .env.local в корневую директорию проекта с содержимым
```
DATABASE_URL="mysql://root:1234@127.0.0.1:3306/emap"
```
Выполнить
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

4 - Запустить в консоли в директории проекта
```
symfony server:start
```
5 - Открыть в браузере
```
http://localhost:8000/
```