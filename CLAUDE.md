# carono.ru — личный сайт-визитка с блогом

Глобальные правила: см. `@/home/carono/.claude/yii2.md` и `@/home/carono/.claude/env.md`.

## Стек
- Yii2 (2.0.x latest) + PHP 8.3
- MariaDB 11 (контейнер `mariadb`, БД `carono_ru`, кодировка `utf8mb4`)
- Bootstrap 5
- carono/yii2-rbac для админки, cebe/markdown для рендера статей

## Где код запускать
Проект смонтирован в контейнер `php83` (PHP-FPM 8.3) тома as-is. Любые `composer`/`./yii` команды — внутри контейнера:

```bash
docker exec -u www-data php83 bash -lc "cd '/mnt/p/projects abandoned/carono/carono.ru' && composer install"
docker exec -u www-data php83 bash -lc "cd '/mnt/p/projects abandoned/carono/carono.ru' && ./yii migrate --interactive=0"
```

PHP-FPM `php83` подключён к сети `webnet`. Для доступа к MariaDB контейнер дополнительно прицеплен к `databases_default`.

## БД и креды
- Hostname (внутри docker): `mariadb`
- БД: `carono_ru`
- Пользователь: `root` (пароль в env-переменных контейнера `mariadb`)
- Конфиг подключения: `config/db.php` (не коммитится), пример в `config/db.php.example`

## Веб-доступ
- Webroot: `web/`
- Nginx-конфиг: `/root/docker/nginx/conf.d/carono.ru.conf` (PHP-FPM: `php83:9000`)
- Локальный домен: `carono.ru.site` (через WSL/Windows hosts)

## Структура
- `controllers/` — публичные контроллеры (Site, Blog)
- `modules/admin/` — админка (с RBAC `can('manageContent')`)
- `models/` — User, Article, Category, Tag (+ search/form-модели)
- `views/layouts/main.php` — публичный, `modules/admin/views/layouts/admin.php` — админский
- `migrations/` — все изменения схемы только через миграции

## Что важно помнить
- Никаких CRLF — `.gitattributes` форсит LF
- Все ассеты подключаются через AssetBundle или `registerCssFile`/`registerJsFile` — никаких `<style>`/`<script>` инлайн во view
- Все пользовательские данные выводятся через `Html::encode()`
- Статьи: markdown в БД, рендер через `cebe/markdown`, кэширование рендера на view-уровне
