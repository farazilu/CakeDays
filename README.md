[![Build Status](https://travis-ci.org/farazilu/CakeDays.svg?branch=master)](https://travis-ci.org/farazilu/CakeDays)

# CakeDays

This utility should receive as an input a text file containing a list of employee birthdays, in
the following format with one entry per line:
*Person Name, Birthday (yyyy-mm-dd)*
The utility should output a CSV detailing the dates we have cake, in the following format:
*Date, Number of Small Cakes, Number of Large Cakes, Names of people getting cake*

“Cake Days” are calculated according to the following rules:

 - A small cake is provided on the employee’s first working day after
   their birthday.
 - All employees get their birthday off.
 - The office is closed on weekends, Christmas Day, Boxing Day and New Year’s Day.
 - If the office is closed on an employee’s birthday, they get the next
   working day off.
 - If two or more cakes days coincide, we instead provide one large cake
   to share.
 - If there is to be cake two days in a row, we instead provide one
   large cake on the second day.
 - For health reasons, the day after each cake must be cake-free. Any
   cakes due on a cake-free day are postponed to the next working day.
 - There is never more than one cake a day.


## Run instructions
 
 Requies PHP 7.1 and PHPUnit 7.0 
 
 **PHPUnit** 
 
 *phpunit --bootstrap bootstrap.php tests/*
 
 **Composer**
 
Install: 

1. Download composer https://getcomposer.org/download/ 

2. *php composer.phar install*

Run: *php ./vendor/bin/phpunit --bootstrap ./vendor/autoload.php tests/*
 
 **PHP CLI** 
 
 *php index.php date* 
 
 --date in formate Y-m-d '2017-01-02' year=2017 month=01 day=02 . 