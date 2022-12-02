<?php

namespace App\Day2;

class Solver
{
    public function solvePartOne(string $input): int
    {
        $score = 0;

        foreach (explode("\n", $input) as $line) {
            if ($line) {
                [$elf, $you] = explode(" ", $line);

                $score += $this->getChoiceScore($you);

                $score += $this->getResultScore($elf, $you);
            }
        }

        return $score;
    }

    public function solvePartTwo(string $input): int
    {
        $score = 0;

        foreach (explode("\n", $input) as $line) {
            if ($line) {
                [$elf, $you] = explode(" ", $line);

                switch ($you) {
                    case 'X':
                        $score += $this->getChoiceScore($this->getChoiceByOutcomeScore($elf, 0));
                        break;
                    case 'Y':
                        $score += $this->getChoiceScore($elf);
                        $score += 3;
                        break;
                    case 'Z':
                        $score += $this->getChoiceScore($this->getChoiceByOutcomeScore($elf, 6));
                        $score += 6;
                        break;
                }
            }
        }

        return $score;
    }

    public function solveRotationPartTwo(string $input): int
    {
        $choices = ['A', 'B', 'C'];
        $score = 0;

        $rotation = [
            'Y' => 0,
            'X' => 2,
            'Z' => 1,
        ];

        $idxByChoice = [
            'A' => 0,
            'B' => 1,
            'C' => 2,
        ];

        foreach (explode("\n", $input) as $line) {
            if ($line) {
                [$choice, $r] = explode(' ', $line);
                $rIdx = ($idxByChoice[$choice] + $rotation[$r]) % 3;
                $score += $this->getChoiceScore($choices[$rIdx]);
                $score += $this->getResultScore($choice, $choices[$rIdx]);
            }
        }

        return $score;
    }

    private function getChoiceByOutcomeScore(string $elf, int $score): string
    {
        return match ($elf) {
            'A' => match ($score) {
                3 => 'A',
                6 => 'B',
                0 => 'C',
            },
            'B' => match ($score) {
                0 => 'A',
                3 => 'B',
                6 => 'C',
            },
            'C' => match ($score) {
                6 => 'A',
                0 => 'B',
                3 => 'C',
            },
        };
    }

    private function getResultScore(string $elf, string $you): int
    {
        return match ($you) {
            'X', 'A' => match ($elf) {
                'A' => 3,
                'B' => 0,
                'C' => 6,
            },
            'Y', 'B' => match ($elf) {
                'A' => 6,
                'B' => 3,
                'C' => 0,
            },
            'Z', 'C' => match ($elf) {
                'A' => 0,
                'B' => 6,
                'C' => 3,
            },
        };
    }

    private function getChoiceScore(string $choice): int
    {
        return match ($choice) {
            'A', 'X' => 1,
            'B', 'Y' => 2,
            'C', 'Z' => 3,
            default => 0,
        };
    }
}
