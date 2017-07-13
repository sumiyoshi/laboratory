<?php


for ($i = 1; $i <= 100; $i++) {

    if ($i % 15 === 0) {
        var_dump('FizzBuzz');
    } elseif ($i % 3 === 0) {
        var_dump('Fizz');
    } elseif ($i % 5 === 0) {
        var_dump('Buzz');
    } else {
        var_dump($i);
    }

}