<?php

class Position
{
    public $x;

    public $y;

    public $previous;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
        $this->previous = null;
    }
}
