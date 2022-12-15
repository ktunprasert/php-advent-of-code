<?php

namespace App\Year2022\Day14;

use App\SolverInterface;

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

    private function parseInputAndSolve(string $input): void
    {
        if ($this->inputParsed) return;

        $grid = new Grid();

        foreach (explode("\n", $input) as $line) {
            $coords = explode(" -> ", $line);
            $i = 0;
            while ($i < count($coords) - 1) {
                [$head, $next] = [
                    explode(",", $coords[$i]),
                    explode(",", $coords[++$i]),
                ];

                $grid->addPoints(...Point::pointsFromCoords(...$head, ...$next));
            }
        }

        $oldCapacity = $grid->sandCapacity;
        while (true) {
            $grid->addSand(500, 0, 10);
            if ($oldCapacity === $grid->sandCapacity) {
                break;
            }
            $oldCapacity = $grid->sandCapacity;
        }
        $this->partOne = $grid->sandCapacity;

        $grid->bottomBound += 2;
        $grid->addPoints(
            ...Point::pointsFromCoords( // sorry... i copped out
                ...[$grid->leftBound - 1_000, $grid->bottomBound],
                ...[$grid->rightBound + 1_000, $grid->bottomBound]
            )
        );

        $oldCapacity = $grid->sandCapacity;
        while (true) {
            $grid->addSand(500, 0, 10);
            if ($oldCapacity === $grid->sandCapacity) {
                break;
            }
            $oldCapacity = $grid->sandCapacity;
        }

        $this->partTwo = $grid->sandCapacity;
        $this->inputParsed = true;
    }
}
