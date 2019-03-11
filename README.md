test-edreams
====

The project is made with Symfony 4.2

## Setup the Project

Please make sure to have docker and docker-compose installed on your local machine before proceeding

Please run the following commands

```bash
docker-compose up -d
```

```bash
docker exec -it -u dev test-edreams_php composer install --no-interaction
```
## Commands

To execute commands please run the desired command followed by it's argument. 
Example:

```bash
docker exec -it -u dev test-edreams_php php bin/console tictactoe:game-move user1 game1 0 0
```


## Testing

To test unit tests

```bash
docker exec -it -u dev test-edreams_php ./vendor/bin/simple-phpunit
```
