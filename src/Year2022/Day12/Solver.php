<?php

namespace App\Year2022\Day12;

use App\SolverInterface;
use Ds\Vector;

class Node
{
    /** @var Vector<Node> $adjacents */
    public Vector $adjacents;
    public bool $start;
    public bool $end;
    public bool $visited = false;

    /** @var Vector<int> $visitedPaths */
    public Vector $visitedPaths;

    public function __construct(
        public string $char,
        public int $x,
        public int $y,
    ) {
        $this->value = Utils::convertValue($char);
        $this->start = $char === 'S';
        $this->end = $char === 'E';
        $this->adjacents = new Vector();
        $this->visitedPaths = new Vector();
    }

    public function isAdjacent(Node $node): bool
    {
        [$a, $b] = [
            $node->x - $this->x,
            $node->y - $this->y,
        ];

        return (($a ** 2 + $b ** 2) === 1);
    }

    public function isLegal(Node $node): bool
    {
        return ($node->value >= $this->value) &&  abs($node->value - $this->value) <= 1;
    }

    public function addAdjacents(...$nodes): void
    {
        /** @var Node[] $nodes */
        $this->adjacents->push(...$nodes);
    }

    public function getAdjacents(): Vector
    {
        return $this->adjacents;
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

        /** @var Vector<Node> */
        $nodes = new Vector();

        $y = 0;
        foreach (explode(PHP_EOL, $input) as $line) {
            $x = 0;
            if ($line === "") continue;

            foreach (str_split($line) as $char) {
                $node = new Node(
                    $char,
                    $x++,
                    $y,
                );

                $nodes->push($node);
            }

            $y++;
        }


        foreach ($nodes as $node) {
            $nodes->apply(function (Node $vectorNode) use (&$node): Node {
                if ($node->value >= $vectorNode->value && $vectorNode->isAdjacent($node) && $vectorNode->isLegal($node)) {
                    $vectorNode->addAdjacents($node);
                }

                return $vectorNode;
            });
        }

        dump($nodes->map(fn ($n) => "$n->char: $n->value ($n->x, $n->y) | " . count($n->adjacents)));

        // [$w, $v] = [$nodes[30], $nodes[29]];
        // $i = $nodes[39];
        // dump($i->adjacents->map(fn ($n) => "$n->char"));
        // return;

        // adjacnets
        // assign node value
        // return all adjacents
        // assign node value
        // return all adjacents
        // until we reach Z
        $begin = $nodes[0];
        // $current = $nodes[0];

        // $nodes[35]->adjacents->clear();

        $c = function (int $visited) use (&$c) {
            $fn = function (Node $n) use (&$c, $visited): Node {
                // dump("$n->char: $visited");
                $n->visited = true;
                $n->visitedPaths->push($visited + 1);
                $n->adjacents->filter(fn (Node $n) => !$n->visited)->apply($c($visited + 1));
                return $n;
            };

            return $fn;
        };

        $begin->adjacents->apply($c(1));

        $nodes->apply(function (Node $n) {
            $n->adjacents->rotate(2);
            $n->visited = false;
            return $n;
        });

        $nodes[0]->adjacents->apply($c(1));

        dump($nodes->filter(fn ($n) => $n->char === 'E')->map(fn ($n) => $n->visitedPaths));

        // $nodes->filter();

        $this->inputParsed = true;
    }
}
