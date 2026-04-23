# PHP Vehicles API with Slim & Mysql

## Τρεξιμο

Μέσα στον Φάκελο

`composer install`

`mv .env_dev .env`  Για την χρηση env variables

`mysql -u root -p < .\database\init\01_schema.sql && mysql -u root -p < .\database\init\02_user_creation.sql` Για τη δημιουργία δοκιμαστικής βάσης Mysql [ή `Get-Content .\database\init\01_schema.sql, .\database\init\02_user_creation.sql | mysql -u root -p` για powershell]

` php -S localhost:8000 -t public` Για έναρξη


## Υποθέσεις

PHP 8.5.5 & MYSQL 8.0.32 

Δεν υπάρχει authentication

Η βάση έχει μερικά vehicles από την αρχή

Ο χρήστης δίνει σωστά στοιχεία, error handling υπάρχει για την περίπτωση όπου κανει request σε endpoint  που δεν υπάρχει και για την περιπτωση όπου χρησιμοποιεί λαθος method πχ. DELETE στο /vehicles

## Σημαντικά

Προστασία απο SQL injection

Error handling για να μην crashάρει 

Διαχωρισμός των λειτουργιών, ξεχωριστα αρχεία για σύνδεση με την βάση, για τα routes, για τα errors
