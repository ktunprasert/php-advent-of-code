<?php

namespace Tests\Unit\Day8;

use App\Year2022\Day8\Solver;
use Tests\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "30373\n25512\n65332\n33549\n35390\n";

        $solver = new Solver();

        $this->assertEquals(21, $solver->solvePartOne($input));
        $this->assertEquals(8, $solver->solvePartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 8),
            new Solver(),
        );
    }
}
