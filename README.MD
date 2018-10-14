## TripSorterExample

#### Task
in task.pdf

#### Install
```
git clone https://github.com/coraxster/TripSorter.git
cd TripSorter

#local install
composer install
# or using docker
docker run --rm -it -v "$PWD":/app composer install --ignore-platform-reqs
```



#### Test
```
#local run
phpunit
#or using docker
docker run -v "$PWD":/app --rm -it phpunit/phpunit -c phpunit.xml
```
#### Run example
```
#local run
php -S localhost:8000 -t example
#or using docker
docker run --rm -it -v "$PWD":/app -w /app -p 8000:8000 php:7.2-alpine php -S 0.0.0.0:8000 -t example

#then browse localhost:8000
```
