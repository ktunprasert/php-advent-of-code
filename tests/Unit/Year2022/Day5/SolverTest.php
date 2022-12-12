<?php

namespace Tests\Unit\Day5;

use App\Year2022\Day5\Solver;
use Lib\AdventClient;
use Tests\TestCase;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "    [D]    \n[N] [C]    \n[Z] [M] [P]\n 1   2   3 \n\n\nmove 1 from 2 to 1\nmove 3 from 1 to 3\nmove 2 from 2 to 1\nmove 1 from 1 to 2";

        $solver = new Solver();

        $this->assertEquals('CMZ', $solver->solvePartOne($input));
        $this->assertEquals('MCD', $solver->solvePartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 5),
            new Solver(),
        );
    }
}
