<?
$i = 0;
while ($i++ < 100) {
    $r = $i % 3 ? '' : "Fizz";
    $i % 5 ?: $r .= "Buzz";
    echo ($r ?: $i) . "\n";
}
