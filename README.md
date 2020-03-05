# ЭМАП

## Идея
Приложение для сбора статистики по исполнениям музыкальных композиций. Позволяет сохранять вариации музыкальных исполнений, классифицировать их и находить совпадения.

## Живой
```
http://emap12.herokuapp.com/
```

## ADR

* [Database](/docs/database_server.md)
* [Production](/docs/production.md)
* [Frontend](/docs/frontend.md)
* [Framework](/docs/server_framework.md)

## Event Storming
### Версия 1
![Event Storming 1](/docs/event_storming1.png)
### Версия 2
![Event Storming 2](/docs/event_storming2.png)

## Архитектура
![Architecture](/docs/architecture.png)

## Структура базы данных
![DB schema](/docs/db_schema.png)

## Диаграмма контейнеров
![Диаграмма контейнеров](/docs/containers.jpg)

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