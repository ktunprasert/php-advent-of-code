<?php

namespace App\Year2022\Day14;

class Point
{
    public function __construct(
        public int $x,
        public int $y,
        public string $char = '#',
    ) {
    }

    public function moveBy(int $vectorX, int $vectorY): void
    {
        $this->x += $vectorX;
        $this->y += $vectorY;
    }

    public static function pointsFromCoords(int $x1, int $y1, int $x2, int $y2): array
    {
        switch (true) {
            case $x1 === $x2:
                return array_map(fn ($y) => new Point($x1, $y), range($y1, $y2));
            case $y1 === $y2:
                return array_map(fn ($x) => new Point($x, $y1), range($x1, $x2));
            default:
                return [];
        }
    }
}
