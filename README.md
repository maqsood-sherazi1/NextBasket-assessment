# NextBasket-assessment
This repository contains a given assessment test by the Next Basket

# Microservice Architecture with Laravel

# Requirements
- PHP >= 8.2
- Docker
- RabbitMQ

## Services

### Users Service
- Endpoint: `POST /users`
- Request Body:
  ```json
  {
    "email": "string",
    "firstName": "string",
    "lastName": "string"
  }

### Notification Service
- Log file: storage/logs/notifications.log

# Setup instructions

## Clone the repository
## Setup environment variables
- .env file

## Run database migrations

# Docker setup
- app (Users service): Laravel app with PHP 8.2
- app (Notifications service): Laravel app with PHP 8.2
- rabbitmq: RabbitMQ message broker for inter-service communication

# Docker commands
- docker-compose up -d
- docker-compose down
- docker-compose logs
# Running Tests
## Run test suite in users service
- cd users-service
- docker-compose exec app php artisan test

## Run test suite in notification service
- cd notification-service
- docker-compose exec app php artisan test

