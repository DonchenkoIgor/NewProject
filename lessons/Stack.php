<?php

class Stack
{
    private $data = [];

    public function add(int $value)
    {
        array_push($this->data, $value);
    }

    public function get(): int
    {
        return array_pop($this->data);
    }

    public function count()
    {
        return count($this->data);
    }

    public function clear()
    {
        $this->data = [];
    }
}

$stack = new Stack();

$stack->add(1);
$stack->add(54);
$stack->add(722);
$stack->add(456);

echo "<br>Count: ";
echo $stack->count(). '<br>';

echo "Stack elements: ". '<br>';
echo $stack->get() . '<br>';
echo $stack->get() . '<br>';
echo $stack->get() . '<br>';
echo $stack->get() . '<br>';

$stack->clear();