<?php

namespace App\Year2022\Day1;

use SplMaxHeap;
use App\SolverInterface;

class Solver implements SolverInterface
{
    public function solvePartOne(string $input): int
    {
        $previousElf = 0;
        $elf = 0;

        foreach (explode("\n", $input) as $line) {
            if ($line) {
                $elf += (int) $line;
            } else {
                if ($elf > $previousElf) {
                    $previousElf = $elf;
                }

                $elf = 0;
            }
        }

        return max($previousElf, $elf);
    }

    public function solvePartTwo(string $input): int
    {
        $previousElves = [];
        $elf = 0;

        foreach (explode("\n", $input) as $line) {
            if ($line) {
                $elf += (int) $line;
            } else {
                if (count($previousElves) < 3) {
                    $previousElves[] = $elf;
                } else {
                    sort($previousElves);
                    foreach ($previousElves as $i => $pElf) {
                        if ($elf > $pElf) {
                            $previousElves[$i] = $elf;
                            break;
                        }
                    }
                }
                $elf = 0;
            }
        }

        sort($previousElves);
        foreach ($previousElves as $i => $pElf) {
            if ($elf > $pElf) {
                $previousElves[$i] = $elf;
                break;
            }
        }

        return array_sum($previousElves);
    }

    public function solveMaxHeap(string $input, int $count = 1): int
    {
        $maxHeap = new SplMaxHeap();
        $elf = 0;
        foreach (explode("\n", $input) as $line) {
            if ($line) {
                $elf += (int) $line;
            } else {
                $maxHeap->insert($elf);
                $elf = 0;
            }
        }

        $maxHeap->insert($elf);

        $total = 0;
        foreach (range(0, $count - 1) as $_) {
            $total += $maxHeap->extract();
        }

        return $total;
    }
}
