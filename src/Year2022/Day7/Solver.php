<?php

namespace App\Year2022\Day7;

use App\SolverInterface;

class Solver implements SolverInterface
{
    private bool $inputParsed = false;
    private array $dirs;

    public function solvePartOne(string $input): int
    {
        $this->parseInput($input);

        $maxSize = 100_000;
        return array_sum(array_filter(array_values($this->dirs), fn (int $s): bool => $s <= $maxSize));
    }

    public function solvePartTwo(string $input): int
    {
        $this->parseInput($input);

        $totalSpace = 70_000_000;
        $requiredSpace = 30_000_000;

        $minimumSpaceForDeletion = $requiredSpace - ($totalSpace - $this->dirs['/']);
        $spaces = array_values($this->dirs);
        sort($spaces);

        foreach ($spaces as $dirSize) {
            if ($dirSize >= $minimumSpaceForDeletion) {
                return $dirSize;
            }
        }

        return 0;
    }

    private function parseInput($input): void
    {
        if ($this->inputParsed) return;

        $root = "/";
        $cwd = "/";

        $logs = explode("\n", $input);
        $i = 0;
        $dirs = [];
        while ($i < count($logs)) {
            if ($logs[$i] === "") break;
            $argv = explode(" ", $logs[$i]);

            switch ($argv[1]) {
                case 'cd':
                    $cwd = match ($argv[2]) {
                        '..' => $this->navigateUp($cwd),
                        '/' => $root,
                        default => "$cwd$argv[2]/",
                    };
                    if (!isset($dirs[$cwd])) $dirs[$cwd] = 0;
                    $i++;
                    break;
                case 'ls':
                    $i++;
                    $size = 0;
                    while ((isset($logs[$i])) && ($logs[$i] !== '') && ($logs[$i][0] !== '$')) {
                        $vars = explode(" ", $logs[$i]);
                        if ($vars[0] !== 'dir') {
                            $size += (int) $vars[0];
                        }
                        $i++;
                    }

                    $wd = $cwd;
                    do {
                        $dirs[$wd] += $size;
                        $wd = $this->navigateUp($wd);
                    } while ($wd !== $root);

                    if ($cwd !== '/') $dirs[$wd] += $size;
                    break;
            }
        }

        $this->inputParsed = true;
        $this->dirs = $dirs;
    }


    private function navigateUp(string $cwd): string
    {
        return preg_replace('/\w+\/$/', '', $cwd);
    }
}
