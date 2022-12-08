<?php

namespace App\Year2022\Day8;

use App\SolverInterface;

class Solver implements SolverInterface
{
    private bool $inputParsed = false;
    private int $partOne;
    private int $partTwo;

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

        $treeCount = 0;
        $maxScore = 1;
        $iterator = explode("\n", $input);
        array_pop($iterator);

        $treesPerRow = strlen($iterator[0]);
        foreach ($iterator as $i => $line) {
            if ($line === "") continue;
            switch ($i) {
                case 0:
                case count($iterator) - 1:
                    $treeCount += $treesPerRow;
                    break;

                default:
                    $treeCount += 2;
                    foreach (range(1, strlen($line) - 2) as $j) {
                        $currentTreeVal = $iterator[$i][$j];

                        $v_vector = array_reduce($iterator, function ($carry, $row) use ($j, $currentTreeVal) {
                            $carry[] = $row[$j] - $currentTreeVal;
                            return $carry;
                        }, []);
                        $h_vector  = array_map(fn ($n) => $n - $currentTreeVal, str_split($iterator[$i]));

                        $top = array_slice($v_vector, 0, $i);
                        $bottom = array_slice($v_vector, $i + 1);
                        $left = array_slice($h_vector, 0, $j);
                        $right = array_slice($h_vector, $j + 1);

                        $left = array_reverse($left);
                        $top = array_reverse($top);

                        foreach ([$top, $bottom, $left, $right] as $arr) {
                            $counts = empty(array_filter($arr, fn ($x) => $x >= 0));
                            if ($counts) {
                                $treeCount++;
                                break;
                            }
                        }

                        $score = 1;
                        foreach ([$top, $bottom, $left, $right] as $arr) {
                            $seen = 0;
                            foreach ($arr as $v) {
                                if ($v >= 0) {
                                    $seen++;
                                    break;
                                }
                                $seen++;
                            }
                            $score *= $seen;
                        }

                        $maxScore = max($score, $maxScore);
                    }
                    break;
            }
        }

        $this->partOne = $treeCount;
        $this->partTwo = $maxScore;
        $this->inputParsed = true;
    }
}
