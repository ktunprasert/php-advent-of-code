<?php

namespace Tests\Unit\Day1;

use App\Day1\Solver;
use PHPUnit\Framework\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = <<<str
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
str;

        $solver = new Solver();
        $this->assertEquals(24000, $solver->solvePartOne($input));
        $this->assertEquals(45000, $solver->solvePartTwo($input));

        $this->assertEquals(24000, $solver->solveMaxHeap($input));
        $this->assertEquals(45000, $solver->solveMaxHeap($input, 3));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->markTestSkipped('Day 1 tests already submitted skipped to not spam the server');

        $client = new AdventClient(2022, 1);
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
