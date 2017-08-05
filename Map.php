<?php

require_once __DIR__ . '/Position.php';

class Map
{
    const ROAD = 0;

    const WALL = 1;

    const START = 2;

    const END = 3;

    public $start;

    public $end;

    public $mapData;

    public $marks;

    public function __construct(array $mapData)
    {
        $this->marks = [];

        $this->mapData = $mapData;

        foreach ($mapData as $x => $row) {
            foreach ($row as $y => $val) {
                if ($val === Map::START) {
                    $this->start = new Position($x, $y);
                }

                if ($val === Map::END) {
                    $this->end = new Position($x, $y);
                }
            }
        }
    }

    public function isEnd(Position $position)
    {
        return $this->mapData[$position->x][$position->y] === static::END;
    }

    public function getRoadsNearBy(Position $position)
    {
        $possiblePositions = [
            new Position($position->x, $position->y - 1), // left
            new Position($position->x, $position->y + 1), // right
            new Position($position->x - 1, $position->y), // top
            new Position($position->x + 1, $position->y)  // bottom
        ];

        foreach ($possiblePositions as $possiblePosition) {
            $possiblePosition->previous = $position;
        }

        return array_filter($possiblePositions, function (Position $position) {
            return (
                isset($this->mapData[$position->x][$position->y])
                && ($this->mapData[$position->x][$position->y] !== static::WALL)
            );
        });
    }

    public function mark(Position $position)
    {
        $this->marks["{$position->x},{$position->y}"] = true;

        return $this;
    }

    public function hasMark(Position $position)
    {
        return isset($this->marks["{$position->x},{$position->y}"]);
    }
}
