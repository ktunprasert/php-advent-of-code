<?php

namespace Tests\Unit\Day4;

use App\Year2022\Day4\Solver;
use Tests\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "2-4,6-8\n2-3,4-5\n5-7,7-9\n2-8,3-7\n6-6,4-6\n2-6,4-8";

        $solver = new Solver();

        $this->assertEquals(2, $solver->solvePartOne($input));
        $this->assertEquals(4, $solver->solvePartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 4),
            new Solver(),
        );
    }
}
