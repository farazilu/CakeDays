<?php
// this file will act as mail conroller for this project..
// check if user has created vendor folder and installed app using composer
if (! file_exists("./vendor")) {
    die("Please install app using composer and put packages in ./vendor folder");
}
if (! file_exists("./vendor/autoload.php")) {
    die("App not installed using composer, ./vendor/autoload.php missing. please try 'php composer.phar install'");
}
require_once './vendor/autoload.php';

if (! file_exists("data/user_input.csv")) {
    die("Input file missing, pleae put your file in './data/user_input.csv ");
}

$csvHandler = new CakeDay\CSVHandler("data/user_input.csv", "data/user_output.csv");
$dateHandler = new CakeDay\UKDateHandeler();

// CakeDay\Birthday::$testYear = 2018;

$cakeDayCalculator = new CakeDay\CakeDayCalculator($dateHandler, $csvHandler);
$cakeDayCalculator->exec();
echo PHP_EOL;
echo "Result are stored in file: ./data/user_output.csv";
echo PHP_EOL;