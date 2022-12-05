<?php

use App\SolverInterface;
use Lib\AdventClient;

require "./vendor/autoload.php";

[$_, $year, $day] = $argv;

$solverClass = "App\\Year$year\\Day$day\\Solver";

/** @var SolverInterface $solver*/
$solver = new $solverClass();

$client = new AdventClient($year, $day);
$input = (string) $client->getInput()->getBody();

echo $solver->solvePartOne($input) . "\n";
echo $solver->solvePartTwo($input) . "\n";
