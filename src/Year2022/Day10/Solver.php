<?php

namespace App\Year2022\Day10;

use App\SolverInterface;

class Solver implements SolverInterface
{
    private bool $inputParsed = false;
    private int $partOne = 0;
    private string $partTwo = 0;

    public function solvePartOne(string $input): int
    {
        $this->parseInputAndSolve($input);

        return $this->partOne;
    }

    public function solvePartTwo(string $input): string
    {
        $this->parseInputAndSolve($input);

        return $this->partTwo;
    }

    private function parseInputAndSolve(string $input): void
    {
        if ($this->inputParsed) return;

        $x = 1;
        $cycles = 0;
        $signalStrength = 0;

        $pixels = [];

        foreach (explode("\n", $input) as $line) {
            if ($line === "") continue;

            $pixels[] = match ($cycles % 40) {
                $x - 1, $x, $x + 1 => '#',
                default => '.',
            };

            match (++$cycles % 40) {
                20 => [$signalStrength += ($x * $cycles)],
                0 => [$pixels[] = "\n"],
                default => 0,
            };

            if (str_starts_with($line, "addx")) {
                [$_, $value] = explode(" ", $line);
                $pixels[] = match ($cycles % 40) {
                    $x - 1, $x, $x + 1 => '#',
                    default => '.',
                };

                match (++$cycles % 40) {
                    20 => [$signalStrength += ($x * $cycles)],
                    0 => [$pixels[] = "\n"],
                    default => 0,
                };

                $x += $value;
            }
        }

        $this->partOne = $signalStrength;
        $this->partTwo = implode("", $pixels);

        $this->inputParsed = true;
    }
}
