<?php
# PHP 5.6.28

class FizzBuzz
{
    public static function run()
    {
        for ($i = 1; $i <= 100; $i++) {

            if ($i % 15 === 0) {
                echo "FizzBuzz" . PHP_EOL;
            } elseif ($i % 3 === 0) {
                echo "Fizz" . PHP_EOL;
            } elseif ($i % 5 === 0) {
                echo "Buzz" . PHP_EOL;
            } else {
                echo $i . PHP_EOL;
            }
        }
    }
}

FizzBuzz::run();
