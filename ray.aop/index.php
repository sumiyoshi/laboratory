<?php

require __DIR__ . '/vendor/autoload.php';


$hello = new Hello();

$advisor = new Advisor(__DIR__ . '/tmp');
$hello_aop = $advisor->newInstance(Hello::class, []);

echo '通常実行===================' . PHP_EOL;
echo $hello->say() . PHP_EOL. PHP_EOL;

echo 'AOP===================' . PHP_EOL;
echo $hello_aop->say() . PHP_EOL. PHP_EOL;


