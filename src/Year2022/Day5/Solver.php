<?php

namespace App\Year2022\Day5;

use App\SolverInterface;

class Solver implements SolverInterface
{
    public function solvePartOne(string $input): string
    {
        [$cratesInput, $movesInput] = explode("\n\n", $input);

        $totalCrates = 0;
        $crates = [];
        foreach (explode("\n", $cratesInput) as $crateLine) {
            if (!$totalCrates) {
                $totalCrates = (int)ceil(strlen($crateLine) / 4);
                $crates = array_fill(0, $totalCrates, []);
            }

            foreach (range(1, $totalCrates * 4, 4) as $k => $i) {
                if ($crateLine[$i] === '1') break;
                if ($crateLine[$i] !== ' ') {
                    array_unshift($crates[$k], $crateLine[$i]);
                }
            }
        }

        foreach (explode("\n", $movesInput) as $moveLine) {
            if (!$moveLine) continue;
            $re = '/(\d+)/';
            preg_match_all($re, $moveLine, $matches, PREG_PATTERN_ORDER, 0);

            [$num, $from, $to] = array_pop($matches);

            foreach (range(0, $num - 1) as $_) {
                $crates[$to - 1][] = array_pop($crates[$from - 1]);
            }
        }

        return implode('', array_map(fn ($arr): string => end($arr), $crates));
    }

    public function solvePartTwo(string $input): string
    {
        [$cratesInput, $movesInput] = explode("\n\n", $input);

        $totalCrates = 0;
        $crates = [];
        foreach (explode("\n", $cratesInput) as $crateLine) {
            if (!$totalCrates) {
                $totalCrates = (int)ceil(strlen($crateLine) / 4);
                $crates = array_fill(0, $totalCrates, []);
            }

            foreach (range(1, $totalCrates * 4, 4) as $k => $i) {
                if ($crateLine[$i] === '1') break;
                if ($crateLine[$i] !== ' ') {
                    array_unshift($crates[$k], $crateLine[$i]);
                }
            }
        }

        foreach (explode("\n", $movesInput) as $moveLine) {
            if (!$moveLine) continue;
            $re = '/(\d+)/';
            preg_match_all($re, $moveLine, $matches, PREG_PATTERN_ORDER, 0);

            [$num, $from, $to] = array_pop($matches);


            $spliced = array_splice($crates[$from-1], -(int)$num, (int)$num);

            array_push($crates[$to-1], ...$spliced);

        }

        return implode('', array_map(fn ($arr): string => end($arr), $crates));
    }
}
