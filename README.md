# Responso
## Symfony Docker
This project is based on the [Symfony Docker](https://github.com/dunglas/symfony-docker)

### To run the project (from the Symfony Docker Readme)
1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up --wait` to set up and start a fresh Symfony project
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## How to use
1. https://localhost/fetch_orders/amazon or https://localhost/fetch_orders/allegro to initiate the fetching of orders from the respective platform.
2. Logs can be viewed in the `var/log/baselinker.log` file (but on the server via e.g. `docker compose exec php cat var/log/baselinker.log`)
3. Phpunit command: `docker compose exec php php bin/phpunit`
4. Behat command: `docker compose exec php vendor/bin/behat`
