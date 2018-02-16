<?php
// this file will act as mail conroller for this project..
// check if user has created vendor folder and installed app using composer
// don't need composer unittest and autoloader psr-4 autoloader workign fine.
// if (! file_exists("./vendor")) {
// die("Please install app using composer and put packages in ./vendor folder");
// }
// if (! file_exists("./vendor/autoload.php")) {
// die("App not installed using composer, ./vendor/autoload.php missing. please try 'php composer.phar install'");
// }
// require_once './vendor/autoload.php';
if (! file_exists("./bootstrap.php")) {
    die("./bootstrap.php missing make sure its in root folder of APP\n");
}

require_once './bootstrap.php';

if (! file_exists("data/user_input.csv")) {
    die("Input file missing, pleae put your file in './data/user_input.csv \n");
}
$date_error_message = "Please enter date in formate Y-m-d '2017-01-02' year=2017 month=01 day=02\n";
if (empty($argv[1])) {
    die($date_error_message);
}

// validate date
$date = explode('-', $argv[1]);

if (strlen($argv[1]) != 10 || count($date) != 3 || strlen($date[0]) != 4 || strlen($date[1]) != 2 || strlen($date[2]) != 2) {
    die($date_error_message);
}

$dateHandler = new CakeDay\UKDateHandeler();

// check if date is valid for PHP DateTime
if (! $dateHandler->dateValidator($argv[1])) {
    die($date_error_message);
}

CakeDay\Birthday::$testYear = $argv[1];

$csvHandler = new CakeDay\CSVHandler("data/user_input.csv", "data/user_output.csv");

$cakeDayCalculator = new CakeDay\CakeDayCalculator($dateHandler, $csvHandler);
$cakeDayCalculator->exec();
echo PHP_EOL;
echo "Result are stored in file: ./data/user_output.csv";
echo PHP_EOL;