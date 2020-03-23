# ЭМАП

## Идея
Приложение для сбора статистики по исполнениям музыкальных композиций. Позволяет сохранять вариации музыкальных исполнений, классифицировать их и находить совпадения.

## Prod
[http://emap12.herokuapp.com](http://emap12.herokuapp.com/)

## Содержание
* [Глоссарий](#глоссарий)
* [Use case diagram](#Use-case-diagram)
* [Онтологическая диаграмма](#онтологическая-диаграмма)
* [Event Storming](#event-storming)
  * [Версия 1](#версия-1)
  * [Версия 2](#версия-2)
* [Архитектура](#архитектура)
* [Структура базы данных](#структура-базы-данных)
* [Диаграмма контейнеров](#диаграмма-контейнеров)
* ADR
  * [Framework](/docs/server_framework.md)
  * [Database](/docs/database_server.md)
  * [Frontend](/docs/frontend.md)
  * [Production](/docs/production.md)
* [Настройка локального окружения](#настройка-локального-окружения)

## Глоссарий
`Особь (Person)` – это отдельная мелодия(напев), исполненная одним исполнителем с одной поэтической строфой. Особь является основной целостной единицей данных самого низкого уровня.

`Семья (Family)` – совокупность особей, каждая особь может принадлежать только одной семье.

`Колония (Colony)` – совокупность семей, каждая семья может иметь только одну колонию.

`Популяция (Population)` – совокупность колоний, каждая популяция может иметь только один вид

`Вид (Specie)` – совокупность популяций.

`Мелограмма (Melogram)` – это графическая модель мелодической линии в виде ломанной кривой, которая отображает изменение высоты звука во времени.

`Меломода (Melomode)` – это плотность нот в каждом промежутке в выборке(склейке).

`Склейка (Union)` – это наложение особей друг на друга с подсчетом меломоды в каждом промежутке

## Use case diagram
[Исходник](/docs/usecase.pu)
![Use case diagram](/docs/img/usecase_diagram.jpg)  

## Онтологическая диаграмма
![Диаграмма контейнеров](/docs/img/ontology_diagram.jpg)

## Event Storming
### Версия 1
![Event Storming 1](/docs/img/event_storming_1_0.png)
### Версия 2
![Event Storming 2](/docs/img/event_storming_2_0.png)

## Архитектура
![Architecture](/docs/img/architecture.png)

## Структура базы данных
![DB schema](/docs/img/db_schema.png)

## Диаграмма контейнеров
[Исходник](/docs/diagram(PlantUML).pu)
![Диаграмма контейнеров](/docs/img/сontainer_diagram.jpg)

## DDD-диаграмма
[Исходник](/docs/puml/components_diagram.pu)
![Диаграмма контейнеров](/docs/img/components_diagram.jpg)

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
