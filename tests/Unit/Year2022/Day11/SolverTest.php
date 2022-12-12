<?php

namespace Tests\Unit\Day11;

use App\Year2022\Day11\Solver;
use Tests\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "Monkey 0:\nStarting items: 79, 98\nOperation: new = old * 19\nTest: divisible by 23\nIf true: throw to monkey 2\nIf false: throw to monkey 3\n\nMonkey 1:\nStarting items: 54, 65, 75, 74\nOperation: new = old + 6\nTest: divisible by 19\nIf true: throw to monkey 2\nIf false: throw to monkey 0\n\nMonkey 2:\nStarting items: 79, 60, 97\nOperation: new = old * old\nTest: divisible by 13\nIf true: throw to monkey 1\nIf false: throw to monkey 3\n\nMonkey 3:\nStarting items: 74\nOperation: new = old + 3\nTest: divisible by 17\nIf true: throw to monkey 0\nIf false: throw to monkey 1\n";

        $solver = new Solver();

        $this->assertEquals(10605, $solver->solvePartOne($input));
        $this->assertEquals(2713310158, $solver->solvePartTwo($input));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->submitAnswersFromClient(
            new AdventClient(2022, 11),
            new Solver(),
        );
    }
}
