<?php

namespace Tests\Unit\Day5;

use App\Day5\Solver;
use PHPUnit\Framework\TestCase;
use Lib\AdventClient;

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
        $this->markTestSkipped('Day 5 tests already submitted skipped to not spam the server');

        $client = new AdventClient(2022, 5);
        $inputRes = $client->getInput();
        $solver = new Solver();

        if ($inputRes->getStatusCode() === 200) {
            $input = (string) $inputRes->getBody();

            if (!$client->submittedPartOne()) {
                $partOneRes = $client->submitPartOne($solver->solvePartOne($input));
                $this->assertStringNotContainsStringIgnoringCase('not the right answer', (string) $partOneRes->getBody());
            }

            if (!$client->submittedPartTwo()) {
                $partTwoRes = $client->submitPartTwo($solver->solvePartTwo($input));
                $this->assertStringNotContainsStringIgnoringCase('not the right answer', (string) $partTwoRes->getBody());
            }
        }
    }
}
