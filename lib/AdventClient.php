<?php

namespace Lib;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Psr7\Response;

class AdventClient
{
    private ClientInterface $client;

    public function __construct(
        private int $year,
        private int $day,
    ) {
        $this->client = new Client(['cookies' => $this->makeCookies()]);
    }

    public function getInput(): Response
    {
        return $this->client->request('GET', "https://adventofcode.com/$this->year/day/$this->day/input");
    }

    public function submittedPartOne(): bool
    {
        $res = $this->client->request('GET', 'https://adventofcode.com');
        return str_contains((string)$res->getBody(), "calendar-day$this->day calendar-complete") || str_contains((string)$res->getBody(), "calendar-day$this->day calendar-verycomplete");
    }

    public function submittedPartTwo(): bool
    {
        $res = $this->client->request('GET', 'https://adventofcode.com');
        return str_contains((string)$res->getBody(), "calendar-day$this->day calendar-verycomplete");
    }

    public function submitPartOne(int $answer): Response
    {
        return $this->submitAnswer(1, $answer);
    }

    public function submitPartTwo(int $answer): Response
    {
        return $this->submitAnswer(2, $answer);
    }

    private function submitAnswer(int $part, int $answer): Response
    {
        return $this->client->request('POST', "https://adventofcode.com/$this->year/day/$this->day/answer", [
            'form_params' => [
                'level' => $part,
                'answer' => $answer,
            ],
        ]);
    }

    private function makeCookies(): CookieJarInterface
    {
        return CookieJar::fromArray(
            ['session' => getenv('SESSION'),],
            '.adventofcode.com'
        );
    }
}
