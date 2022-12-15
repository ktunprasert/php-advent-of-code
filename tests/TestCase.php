<?php

namespace Tests;

use App\SolverInterface;
use Lib\AdventClient;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function submitAnswersFromClient(
        AdventClient $client,
        SolverInterface $solver,
        bool $skipPartTwo = false,
    ): void {
        if ($client->solved()) {
            $this->assertEquals(2, $client->getDateStars());
            return;
        }

        $inputRes = $client->getInput();
        $this->assertEquals(200, $inputRes->getStatusCode());

        $input = (string) $inputRes->getBody();

        switch ($client->getDateStars()) {
            case 0:
                $partOneRes = $client->submitPartOne($solver->solvePartOne($input));
                $this->assertStringNotContainsStringIgnoringCase('not the right answer', (string) $partOneRes->getBody());
            case 1:
                if ($skipPartTwo) break;
                $partTwoRes = $client->submitPartTwo($solver->solvePartTwo($input));
                $this->assertStringNotContainsStringIgnoringCase('not the right answer', (string) $partTwoRes->getBody());
                break;
        }
    }
}
