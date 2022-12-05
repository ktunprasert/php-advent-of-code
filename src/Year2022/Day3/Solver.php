<?php

namespace App\Year2022\Day3;

use App\SolverInterface;

class Solver implements SolverInterface
{
    public function solvePartOne(string $input): int
    {
        $duped = [];
        foreach (explode("\n", $input) as $line) {
            if (!$line) continue;
            $midLength = strlen($line) / 2;
            $leftSack = [];

            foreach (range(0, $midLength - 1) as $i) {
                $leftSack[$line[$i]] = 1;
            }

            foreach (range($midLength, strlen($line) - 1) as $i) {
                if (isset($leftSack[$line[$i]])) {
                    $duped[] = $line[$i];
                    break;
                }
            }
        }

        $sum = 0;
        foreach ($duped as $char) {
            $sum += $this->getPriority($char);
        }

        return $sum;
    }

    public function solvePartTwo(string $input): int
    {
        $sum = 0;

        foreach (array_chunk(explode("\n", $input), 3) as $chunk) {
            if (count($chunk) === 1) break;
            $map = array_fill(0, 52, 0);
            $round = 1;
            foreach ($chunk as $line) {
                foreach (str_split($line) as $c) {
                    $idx = $this->getPriority($c) - 1;
                    if ($map[$idx] === $round - 1) {
                        $map[$idx] = $round;
                    }
                }
                $round++;
            }
            $sum += array_search(3, $map) + 1;
        }

        return $sum;
    }

    private function getPriority(string $char): int
    {
        switch ($char) {
            case ($char >= 'a' && $char <= 'z'):
                return ord($char) - 96;
            case ($char >= 'A' && $char <= 'Z'):
                return ord($char) - 64 + 26;
        };
    }
}
