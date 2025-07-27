Для запуска проекта необходимо предварительно установить Docker Desktop.
После клонирования репозитория в командной строке в папке проекта прописать
1. docker-compose up
2. docker-compose exec php bash
3. composer install
4. php yii migrate
5. при необходимости написать в bash:
  chown -R www-data:www-data /app/web/assets
  chmod -R 775 /app/web/assets
6. Затем перейти по ссылке : http://localhost:8000/link/index или открыть страницу проекта через Docker Desktop
