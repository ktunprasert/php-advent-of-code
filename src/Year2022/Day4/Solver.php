<?php

namespace App\Year2022\Day4;

use App\SolverInterface;

class Solver implements SolverInterface
{
    public function solvePartOne(string $input): int
    {
        $overlap = 0;
        foreach (explode("\n", $input) as $pair) {
            if (!$pair) break;
            $elves = [];
            foreach (explode(",", $pair) as $elf) {
                [$start, $end] = explode("-", $elf);
                $elves[] = [
                    'start' => (int)$start,
                    'end' => (int)$end,
                    'total' => abs((int)$end - (int)$start),
                ];
            }

            [$firstElf, $secondElf] = $elves;
            switch ($firstElf['total'] <=> $secondElf['total']) {
                case 0:
                    if ($firstElf['start'] === $secondElf['start'] && $firstElf['end'] === $secondElf['end']) {
                        $overlap++;
                    }
                    break;
                case -1: // RHS bigger
                    if ($firstElf['start'] >= $secondElf['start'] && $firstElf['end'] <= $secondElf['end']) {
                        $overlap++;
                    }
                    break;
                case 1: // LHS bigger
                    if ($firstElf['start'] <= $secondElf['start'] && $firstElf['end'] >= $secondElf['end']) {
                        $overlap++;
                    }
                    break;
            }
        }
        return $overlap;
    }

    public function solvePartTwo(string $input): int
    {
        $overlap = 0;
        foreach (explode("\n", $input) as $pair) {
            if (!$pair) break;
            [$firstElf, $secondElf] = explode(",", $pair);
            $rangeMap = [];

            [$start, $end] = explode("-", $firstElf);

            foreach (range($start, $end) as $key) {
                $rangeMap[$key] = 1;
            }

            [$start, $end] = explode("-", $secondElf);
            $exitCond = false;
            foreach (range($start, $end) as $key) {
                if ($exitCond) break;
                if (isset($rangeMap[$key])) {
                    $overlap++;
                    $exitCond = true;
                }
            }
        }

        return $overlap;
    }
}
