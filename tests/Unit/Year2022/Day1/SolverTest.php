<?php

namespace Tests\Unit\Day1;

use App\Year2022\Day1\Solver;
use PHPUnit\Framework\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $input = "1000\n2000\n3000\n\n4000\n\n5000\n6000\n\n7000\n8000\n9000\n\n10000\n";

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
