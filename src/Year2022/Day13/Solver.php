<?php

namespace App\Year2022\Day13;

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

        $validPairs = [];
        $currentPair = 1;

        $pairs = [];

        $compareClosure = function ($a, $b) use (&$compareClosure): int {
            if (
                gettype($a) === 'integer' &&
                gettype($b) === 'integer'
            ) {
                $cmp = $a <=> $b;
                return $a <=> $b;
            }

            $a = gettype($a) === 'integer' ? [$a] : $a;
            $b = gettype($b) === 'integer' ? [$b] : $b;

            if (empty($a) || empty($b)) {
                return count($a) <=> count($b);
            }

            $cmp = $compareClosure(array_shift($a), array_shift($b));
            if ($cmp !== 0) {
                return $cmp;
            }

            return $compareClosure($a, $b);
        };

        foreach (explode("\n\n", $input) as $chunk) {
            dump($chunk);
            [$leftChunk, $rightChunk] = explode("\n", $chunk);

            /** @var array $leftPackets */
            /** @var array $rightPackets */
            $leftPackets = eval("return $leftChunk;");
            $rightPackets = eval("return $rightChunk;");

            $pairs[] = $leftPackets;
            $pairs[] = $rightPackets;


            if ($compareClosure($leftPackets, $rightPackets) === -1) {
                $validPairs[] = $currentPair;
            }

            $currentPair++;
        }

        $pairs[] = [[2]];
        $pairs[] = [[6]];
        usort($pairs, $compareClosure);

        $i = 1;
        $decoder = array_reduce($pairs, function ($carry, $item) use (&$i) {
            if (in_array(json_encode($item), [
                json_encode([[2]]),
                json_encode([[6]]),
            ])) {
                $carry[] = $i;
            }
            $i++;

            return $carry;
        }, []);

        $this->partOne = array_sum($validPairs);
        $this->partTwo = $decoder[0] * $decoder[1];
        $this->inputParsed = true;
    }
}
