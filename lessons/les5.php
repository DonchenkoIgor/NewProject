<?php

function fibonacciSum($n) {
    $fib = [0, 1];
    $sum = 1;

    for ($i = 2; $i < $n; $i++) {
        $fib[$i] = $fib[$i - 1] + $fib[$i - 2];
        $sum += $fib[$i];
    }

    echo "Первые $n чисел Фибоначчи: " . '<br>';
    foreach ($fib as $num) {
        echo $num . ' ' . '<br>';
    }
    echo "\nСумма первых $n чисел Фибоначчи: " . $sum . '<br>';
}

fibonacciSum(10);
