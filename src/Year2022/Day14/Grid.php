<?php

namespace App\Year2022\Day14;

use Ds\Vector;

class Grid
{
    public Vector $coords;
    public array $grid;
    public int $rightBound = 0;
    public int $leftBound = 100_000_000;
    public int $bottomBound = 0;
    public int $sandCapacity = 0;

    public function __construct()
    {
        $this->coords = new Vector();
    }

    public function addPoints(Point ...$points): void
    {
        $this->coords->push($points);

        foreach ($points as $p) {
            $this->sandCapacity += match ($p->char) {
                'o' => 1,
                '#' => 0,
            };
            $this->updateBound($p);
            $this->grid["$p->x#$p->y"] = $p;
        }
    }

    public function isBlocked(int $x, int $y): bool
    {
        return isset($this->grid["$x#$y"]);
    }

    public function addSand(int $x, int $y, int $number = 1): void
    {
        $i = 1;

        while ($i++ < $number) {
            $point = $this->fallUntilCollision(new Point($x, $y, 'o'));
            if (!isset($point)) {
                break;
            }
            $this->addPoints($point);
        }
    }

    public function fallUntilCollision(Point $p): ?Point
    {
        switch (true) {
            case $this->bottomBound < $p->y:
            case $this->isBlocked($p->x, $p->y):
                return null;
            case !$this->isBlocked($p->x, $p->y + 1):
                $p->moveBy(0, 1);
                break;
            case !$this->isBlocked($p->x - 1, $p->y + 1):
                $p->moveBy(-1, 1);
                break;
            case !$this->isBlocked($p->x + 1, $p->y + 1):
                $p->moveBy(1, 1);
                break;
            default:
                return $p;
        }

        return $this->fallUntilCollision($p);
    }

    public function drawGrid(): string
    {
        $horizontalBound = abs($this->leftBound - $this->rightBound);
        $str = array_chunk(array_fill(0, $horizontalBound * $this->bottomBound, "."), $horizontalBound);

        foreach ($this->grid as $p) {
            $x = $p->x % $this->leftBound;

            $str[$p->y][$x] = $p->char;
        }

        $s = implode("\n", array_map(fn ($arr) => implode('', $arr), $str));
        return $s;
    }

    private function updateBound(Point $p): void
    {
        $this->rightBound = max($this->rightBound, $p->x);
        $this->leftBound = min($this->leftBound, $p->x);
        $this->bottomBound = max($this->bottomBound, $p->y);
    }
}
