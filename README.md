# PHP Vehicles API with Slim & Mysql

## Τρεξιμο

Περιβάλλον PHP 8.5.5 & MYSQL 8.0.32, σιγουρευτείτε πως τα extensions pdf_mysql, mysqli είναι ενεργοποιημένα στο php.ini

Μέσα στον Φάκελο

`composer install`

`mv .env_dev .env`  Για την χρηση env variables

Windows: `mysql -u root -p < .\database\init\01_schema.sql && mysql -u root -p < .\database\init\02_user_creation.sql` Για τη δημιουργία δοκιμαστικής βάσης Mysql [ή `Get-Content .\database\init\01_schema.sql, .\database\init\02_user_creation.sql | mysql -u root -p` για powershell]

Linux : `sudo mysql < database\init\01_schema.sql && sudo mysql < database\init\02_user_creation.sql

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
