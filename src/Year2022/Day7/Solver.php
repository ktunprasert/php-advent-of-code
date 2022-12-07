<?php

namespace App\Year2022\Day7;

use App\SolverInterface;

class Solver implements SolverInterface
{
    public function solvePartOne(string $input): int
    {
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
                    $j = $i + 1;
                    $lsOut = [];
                    while ((isset($logs[$j])) && ($logs[$j] !== '') && ($logs[$j][0] !== '$')) {
                        $lsOut[] = $logs[$j];
                        $j++;
                    }
                    $i = $j;

                    $size = 0;
                    foreach ($lsOut as $ls) {
                        $vars = explode(" ", $ls);
                        if ($vars[0] !== 'dir') {
                            $size += (int) $vars[0];
                        }
                    }

                    $wd = $cwd;
                    do {
                        $dirs[$wd] += $size;
                        $wd = $this->navigateUp($wd);
                    } while ($wd !== $root);

                    if ($cwd === '/') break;
                    $dirs[$wd] += $size;
                    break;
            }
        }

        $maxSize = 100_000;
        return array_sum(array_filter(array_values($dirs), fn (int $s): bool => $s <= $maxSize));
    }

    private function navigateUp(string $cwd): string
    {
        return preg_replace('/\w+\/$/', '', $cwd);
    }

    public function solvePartTwo(string $input): int
    {
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
                    $j = $i + 1;
                    $lsOut = [];
                    while ((isset($logs[$j])) && ($logs[$j] !== '') && ($logs[$j][0] !== '$')) {
                        $lsOut[] = $logs[$j];
                        $j++;
                    }
                    $i = $j;

                    $size = 0;
                    foreach ($lsOut as $ls) {
                        $vars = explode(" ", $ls);
                        if ($vars[0] !== 'dir') {
                            $size += (int) $vars[0];
                        }
                    }

                    $wd = $cwd;
                    do {
                        $dirs[$wd] += $size;
                        $wd = $this->navigateUp($wd);
                    } while ($wd !== $root);

                    if ($cwd === '/') break;
                    $dirs[$wd] += $size;
                    break;
            }
        }

        $totalSpace = 70_000_000;
        $requiredSpace = 30_000_000;

        $minimumSpaceForDeletion = $requiredSpace - ($totalSpace - $dirs['/']);
        $spaces = array_values($dirs);
        sort($spaces);

        foreach($spaces as $dirSize) {
            if ($dirSize >= $minimumSpaceForDeletion) {
                return $dirSize;
            }
        }

        return 0;
    }
}
