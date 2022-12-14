<?php

namespace Tests\Unit\Day9;

use App\Year2022\Day9\Solver;
use Tests\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "R 4\nU 4\nL 3\nD 1\nR 4\nD 1\nL 5\nR 2\n";
        $solver = new Solver();
        $this->assertEquals(13, $solver->solvePartOne($input));
        $this->assertEquals(1, $solver->solvePartTwo($input));

        $input = "R 5\nU 8\nL 8\nD 3\nR 17\nD 10\nL 25\nU 20";
        $solver = new Solver();
        $this->assertEquals(36, $solver->solvePartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 9),
            new Solver(),
        );
    }
}
