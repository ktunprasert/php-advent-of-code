<?php

namespace App\Year2022\Day6;

use App\SolverInterface;

class Solver implements SolverInterface
{
    public function solvePartOne(string $input): int
    {
        foreach (range(0, strlen($input) - 4) as $idx) {
            $temp = substr($input, $idx, 4);
            if (count(array_count_values(str_split($temp))) === 4) {
                return $idx + 4;
            }
        }

        return 0;
    }

    public function solvePartTwo(string $input): int
    {
        $length = 14;
        foreach (range(0, strlen($input) - $length) as $idx) {
            $temp = substr($input, $idx, $length);
            if (count(array_count_values(str_split($temp))) === $length) {
                return $idx + $length;
            }
        }

        return 0;
    }
}
