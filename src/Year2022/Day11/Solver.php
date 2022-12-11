<?php

namespace App\Year2022\Day11;

use App\SolverInterface;
use Closure;

class Monkey
{
    public int $inspected = 0;
    public Closure $modifyWorry;

    public function __construct(
        public \Ds\Vector $items,
        public Closure $operation,
        public int $division,
        public int $trueMonkey,
        public int $falseMonkey,
    ) {
        $this->modifyWorry = fn (int $worry) => $worry / 3;
    }

    public function addItem(array $items): void
    {
        $this->items->push(...$items);
    }

    public function play(): array
    {
        $thrown = [];

        $closure = function ($worry) use (&$thrown) {
            $worry = (int) floor(($this->modifyWorry)(($this->operation)($worry)));

            $monkey = $worry % $this->division ? $this->falseMonkey : $this->trueMonkey;

            if (isset($thrown[$monkey])) {
                $thrown[$monkey][] = $worry;
            } else {
                $thrown[$monkey] = [$worry];
            }
        };

        $this->inspected += count($this->items);
        $this->items->apply($closure);
        $this->items->clear();

        return $thrown;
    }

    public static function fromPrompt(string $prompt): self
    {
        [$_, $itemsLine, $operationLine, $divisibleLine, $trueLine, $falseLine] = explode("\n", $prompt);

        if (preg_match_all('/\d+/', $itemsLine, $items, PREG_PATTERN_ORDER, 0)) {
            $items = $items[0];
        }

        [$_, $equation] = explode(" = ", $operationLine);
        $lambdaEquation = str_replace("old", '$x', $equation);

        $closure = fn ($x) => $x;
        eval("\$closure = fn(\$x): int => $lambdaEquation;");

        preg_match('/\d+/', $divisibleLine, $divBy);
        preg_match('/\d+/', $trueLine, $true);
        preg_match('/\d+/', $falseLine, $false);

        return new self(
            new \Ds\Vector($items),
            $closure,
            $divBy[0],
            $true[0],
            $false[0],
        );
    }
}

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

        /** @var Monkey[] */
        $firstPartMonkeys = [];

        /** @var Monkey[] */
        $secondPartMonkeys = [];

        $bound = 1;

        foreach (explode("\n\n", $input) as $prompt) {
            $monkey = Monkey::fromPrompt($prompt);
            $bound *= $monkey->division;
            $firstPartMonkeys[] = $monkey;
            $secondPartMonkeys[] = Monkey::fromPrompt($prompt, false);
        }

        foreach ($secondPartMonkeys as $monkey) {
            $monkey->modifyWorry = fn (int $worry): int => $worry % $bound;
        }

        foreach (range(1, 20) as $_) {
            foreach ($firstPartMonkeys as $monkey) {
                $thrownItems = $monkey->play();

                foreach ($thrownItems as $monkeyIdx => $items) {
                    $firstPartMonkeys[$monkeyIdx]->addItem($items);
                }
            }
        }

        foreach (range(1, 10_000) as $_) {
            foreach ($secondPartMonkeys as $monkey) {
                $thrownItems = $monkey->play();

                foreach ($thrownItems as $monkeyIdx => $items) {
                    $secondPartMonkeys[$monkeyIdx]->addItem($items);
                }
            }
        }

        usort($firstPartMonkeys, fn (Monkey $a, Monkey $b): int => $b->inspected - $a->inspected);
        usort($secondPartMonkeys, fn (Monkey $a, Monkey $b): int => $b->inspected - $a->inspected);

        $this->partOne = $firstPartMonkeys[0]->inspected * $firstPartMonkeys[1]->inspected;
        $this->partTwo = $secondPartMonkeys[0]->inspected * $secondPartMonkeys[1]->inspected;

        $this->inputParsed = true;
    }
}
