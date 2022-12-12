<?php

namespace Lib;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\DomCrawler\Crawler;

class AdventClient
{
    private ClientInterface $client;
    private static array $submissionStatus = [];

    public function __construct(
        private int $year,
        private int $day,
    ) {
        $this->client = new Client(['cookies' => $this->makeCookies()]);
        $this->buildCurrentYearSubmissionStatus();
    }

    public function getInput(): Response
    {
        return $this->client->request('GET', "https://adventofcode.com/$this->year/day/$this->day/input");
    }

    public function getDateStars(): int
    {
        return static::$submissionStatus[$this->year][$this->day] ?? 0;
    }

    public function solved(): bool
    {
        return $this->getDateStars() == 2;
    }

    public function unsolved(): bool
    {
        return $this->getDateStars() == 0;
    }

    public function submittedPartOne(): bool
    {
        return $this->getDateStars() >= 1;
    }

    public function submittedPartTwo(): bool
    {
        return $this->getDateStars() == 2;
    }

    public function submitPartOne(mixed $answer): Response
    {
        return $this->submitAnswer(1, $answer);
    }

    public function submitPartTwo(mixed $answer): Response
    {
        return $this->submitAnswer(2, $answer);
    }

    private function submitAnswer(int $part, mixed $answer): Response
    {
        return $this->client->request('POST', "https://adventofcode.com/$this->year/day/$this->day/answer", [
            'form_params' => [
                'level' => $part,
                'answer' => $answer,
            ],
        ]);
    }

    private function buildCurrentYearSubmissionStatus(): void
    {
        if (isset(static::$submissionStatus[$this->year])) return;

        $res = $this->client->request('GET', "https://adventofcode.com/$this->year");
        $body = (string) $res->getBody();

        $crawler = new Crawler($body);
        $calendar = array_fill_keys(range(1, 25), 0);
        foreach ($crawler->filter('.calendar > a')->extract(['class']) as $availableDays) {
            $dayClasses = explode(' ', $availableDays);
            $dayText = $dayClasses[0];
            $dayStatus = "";

            if (str_contains($availableDays, ' ')) {
                $dayStatus = $dayClasses[1];
            }

            $day = abs(filter_var($dayText, FILTER_SANITIZE_NUMBER_INT));

            $calendar[$day] = match ($dayStatus) {
                'calendar-complete' => 1,
                'calendar-verycomplete' => 2,
                default => 0,
            };
        }

        static::$submissionStatus[$this->year] = $calendar;
    }

    private function makeCookies(): CookieJarInterface
    {
        return CookieJar::fromArray(
            ['session' => getenv('SESSION'),],
            '.adventofcode.com'
        );
    }
}
