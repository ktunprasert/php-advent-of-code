<?php

namespace Tests\Unit\Day14;

use App\Year2022\Day14\Solver;
use Tests\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "498,4 -> 498,6 -> 496,6\n503,4 -> 502,4 -> 502,9 -> 494,9\n";

        $solver = new Solver();

        $this->assertEquals(24, $solver->solvePartOne($input));
        $this->assertEquals(93, $solver->solvePartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 14),
            new Solver(),
        );
    }
}
