<?php

namespace Tests\Unit\Day2;

use App\Day2\Solver;
use PHPUnit\Framework\TestCase;
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
        $this->markTestSkipped('Day 2 tests already submitted skipped to not spam the server');

        $client = new AdventClient(2022, 2);
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
