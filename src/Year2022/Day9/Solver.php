<?php

namespace App\Year2022\Day9;

use App\SolverInterface;

class Point
{
    // thanks Povilas
    public array $visited = ["0#0" => 1];

    public function __construct(
        public int $x = 0,
        public int $y = 0,
    ) {
    }

    public function teleport(int $x, int $y): void
    {
        $this->putVisited("$x#$y");
        $this->x = $x;
        $this->y = $y;
    }

    public function move(int $x, int $y): void
    {
        $this->x += $x;
        $this->y += $y;
        $this->putVisited("{$this->x}#{$this->y}");
    }

    private function putVisited(string $hash): void
    {
        $this->visited[$hash] = 1;
    }
}

class Solver implements SolverInterface
{
    private bool $inputParsed = false;
    private int $partOne = 0;
    private int $partTwo = 0;

    public function solvePartOne(string $input): int
    {
        $this->parseInputAndSolve($input);

        return $this->partOne;
    }

    public function solvePartTwo(string $input): int
    {
        $this->parseInputAndSolve($input);

        return $this->partTwo;
    }

    private function adjacent(Point $head, Point $tail): bool
    {
        [$a, $b] = [
            $head->x - $tail->x,
            $head->y - $tail->y,
        ];

        return ($a ** 2 + $b ** 2) <= 2;
    }

    private function clamp(int $num, int $min, int $max): int
    {
        return max(min($num, $max), $min);
    }

    private function parseInputAndSolve(string $input): void
    {
        if ($this->inputParsed) return;

        $head = new Point();
        $tail = new Point();

        $snakes = array_map(fn (): Point => new Point(), range(1, 10));

        foreach (explode("\n", $input) as $line) {
            if ($line === '') continue;
            [$direction, $steps] = explode(" ", $line);

            $vector = match ($direction) {
                "U" => [0, 1],
                "D" => [0, -1],
                "L" => [-1, 0],
                "R" => [1, 0],
            };

            foreach (range(1, $steps) as $_) {
                // p1
                $head->move(...$vector);
                if (!$this->adjacent($head, $tail)) {
                    $tail->teleport(...[
                        $head->x - $vector[0],
                        $head->y - $vector[1],
                    ]);
                }

                // p2
                $i = 0;
                /** @var Point **/
                $snakes[0]->move(...$vector);
                foreach (range(1, count($snakes) - 1) as $_) {
                    [$snakeHead, $snakeNext] = [$snakes[$i], $snakes[++$i]];

                    $snakeVector = [
                        $this->clamp($snakeHead->x - $snakeNext->x, -1, 1),
                        $this->clamp($snakeHead->y - $snakeNext->y, -1, 1),
                    ];

                    if (!$this->adjacent($snakeHead, $snakeNext)) {
                        $snakeNext->move(...$snakeVector);
                    }
                }
            }
        }

        $this->partOne = count($tail->visited);
        $this->partTwo = count(array_pop($snakes)->visited);

        $this->inputParsed = true;
    }
}
