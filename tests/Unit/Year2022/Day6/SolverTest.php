<?php

namespace Tests\Unit\Day6;

use App\Year2022\Day6\Solver;
use PHPUnit\Framework\TestCase;
use Lib\AdventClient;

class SolverTest extends TestCase
{
    public function test_it_pass_example_test(): void
    {
        $solver = new Solver();

        // Part 1
        $this->assertEquals(7, $solver->solvePartOne('mjqjpqmgbljsphdztnvjfqwrcgsmlb'));
        $this->assertEquals(5, $solver->solvePartOne('bvwbjplbgvbhsrlpgdmjqwftvncz'));
        $this->assertEquals(6, $solver->solvePartOne('nppdvjthqldpwncqszvftbrmjlhg'));
        $this->assertEquals(10, $solver->solvePartOne('nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg'));
        $this->assertEquals(11, $solver->solvePartOne('zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw'));

        // Part 2
        $this->assertEquals(19, $solver->solvePartTwo('mjqjpqmgbljsphdztnvjfqwrcgsmlb'));
        $this->assertEquals(23, $solver->solvePartTwo('bvwbjplbgvbhsrlpgdmjqwftvncz'));
        $this->assertEquals(23, $solver->solvePartTwo('nppdvjthqldpwncqszvftbrmjlhg'));
        $this->assertEquals(29, $solver->solvePartTwo('nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg'));
        $this->assertEquals(26, $solver->solvePartTwo('zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw'));
    }

    public function test_it_submits_correct_answer(): void
    {
        $this->markTestSkipped('Day 6 tests already submitted skipped to not spam the server');

        $client = new AdventClient(2022, 6);
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
