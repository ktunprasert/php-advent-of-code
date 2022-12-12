<?php

namespace Tests\Unit\Day7;

use App\Year2022\Day7\Solver;
use Lib\AdventClient;
use Tests\TestCase;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "$ cd /\n$ ls\ndir a\n14848514 b.txt\n8504156 c.dat\ndir d\n$ cd a\n$ ls\ndir e\n29116 f\n2557 g\n62596 h.lst\n$ cd e\n$ ls\n584 i\n$ cd ..\n$ cd ..\n$ cd d\n$ ls\n4060174 j\n8033020 d.log\n5626152 d.ext\n7214296 k";

        $solver = new Solver();

        $this->assertEquals(95437, $solver->solvePartOne($input));
        $this->assertEquals(24933642, $solver->solvePartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 7),
            new Solver(),
        );
    }
}
