<?php

class Animal
{
    function run()
    {
        echo 'i can run';
    }

    function breath()
    {
        echo 'i can breath';
    }
}

class Lion extends Animal
{
    function roar()
    {
        echo 'i can roar';
    }
}

class Shark extends Animal
{
    function swim()
    {
        echo 'i can swim';
    }
}

$animal = new Animal;
$lion = new Lion;
$shark = new Shark;

$shark->swim() . "<br> <br>";
echo "<br>";
$animal->breath();



