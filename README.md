# Installation

1. Run:
```
git clone <repository_url>
composer install
```

2. Run (MySQL CLI or via phpMyAdmin):
```
CREATE DATABASE currencies_db;
CREATE USER 'currencies_app'@'localhost' IDENTIFIED BY '7tnbMlNMjMrw3BtviiaX';
GRANT ALL PRIVILEGES ON currencies_db.* TO 'currencies_app'@'localhost';
```

3. Run:
```
php bin/console doctrine:schema:update --force
php bin/console cache:clear
```

# Unit testing
Run:
```
./bin/phpunit
php bin/phpunit
```

# Usage

## Update currencies (triggers notifications for registered users)
Run:
```
php bin/console app:update-exchange-rates
```
