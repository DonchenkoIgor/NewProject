<?php

class Queue
{
    private $data = [];

    public function add(int $value)
    {
        array_push($this->data, $value);
    }

    public function get()
    {
        return array_shift($this->data);
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

$queue = new Queue;

$queue->add(2);
$queue->add(70);
$queue->add(333);

echo "<br>Count: ";
echo $queue->count(). '<br>';

echo "Queue elements: " . '<br>';
echo $queue->get()  . '<br>';
echo $queue->get()  . '<br>';
echo $queue->get()  . '<br>';

$queue->clear();
