# laravel-industry-arts

## Requirements

PHP 8.

## Installation

Edit your hosts file, add this line:

``127.0.0.1 laravel-industry-arts.test``

### Installation without Docker

1. Save `.env.example` as `.env`. Update settings inside the `.env` file (database user/pass).
2. Run `composer install`.
3. Run `php artisan migrate`.
4. You should update your nginx/apache config (or use `php artisan serve` instead).


### Installation with Docker

Run the following commands for installation:

```
cd /path/to/the/laravel/directory

WWWGROUP=$(id -g)
export WWWGROUP
export WWWUSER=$UID

cp .env.example .env

docker-compose up --build -d
docker-compose exec laravel-industry-arts.test composer install
docker-compose exec laravel-industry-arts.test composer run post-root-package-install
docker-compose exec laravel-industry-arts.test composer run post-create-project-cmd

vendor/bin/sail up
vendor/bin/sail php artisan migrate
vendor/bin/sail php artisan test
```

## API


### Squares

`quizzes/square?n=2 [POST/GET]`
```JSON
{
  "data": {
    "value": 4,
    "number": 2,
    "occurrences": 1,
    "datetime": 1639880995
  }
}

```


### Triplets

`/quizzes/triplet?a=3&b=4&c=5 [POST/GET]`

```JSON
{
  "data": {
    "a": 3,
    "b": 4,
    "c": 5,
    "n": 60,
    "is_pythagorean": true,
    "occurrences": 1,
    "datetime": 1639881025
  }
}
```

### Error Sample

```JSON
{
  "errors": {
    "a": [
      "The a field is required."
    ],
    "b": [
      "The b field is required."
    ],
    "c": [
      "The c field is required."
    ]
  }
}
```
