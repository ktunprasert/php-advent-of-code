<?php

namespace Tests\Unit\Day2;

use App\Year2022\Day2\Solver;
use Tests\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "A Y\nB X\nC Z";

        $solver = new Solver();

        $this->assertEquals(15, $solver->solvePartOne($input));
        $this->assertEquals(12, $solver->solvePartTwo($input));

        $this->assertEquals(12, $solver->solveRotationPartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 2),
            new Solver(),
        );
    }
}
