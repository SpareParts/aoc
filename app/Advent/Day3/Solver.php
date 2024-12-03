<?php
declare(strict_types=1);

namespace App\Advent\Day3;

use Arrayy\Arrayy as A;
use Tempest\Console\ConsoleCommand;

final readonly class Solver
{
    #[ConsoleCommand('advent:day3-1')]
    public function solve1(): void
    {
        $input = file_get_contents(__DIR__ . '/input2.txt');

        $matches = []; preg_match_all("/mul\((\d+),(\d+)\)/m", $input, $matches);
        $res = A::create($matches[1])->reduce(fn($sum, $v, $k) => $sum + $v * $matches[2][$k], 0);

        var_dump($res->toJson());
    }

    #[ConsoleCommand('advent:day3-2')]
    public function solve2(): void
    {
        $input = file_get_contents(__DIR__ . '/input2.txt');
        $input = implode(explode("\n", $input));

        $matches = []; preg_match_all("/do\(\)(.*?)don't\(\)/m", 'do()'.$input.'don\'t()', $matches);

        $x = A::create($matches[1])->map(function($v) {
            $matches = []; preg_match_all("/mul\((\d+),(\d+)\)/", $v, $matches);
            return A::create($matches[1])->reduce(fn($sum, $v, $k) => $sum + $v * $matches[2][$k], 0);
        })->reduce(fn($c, $v) => $c + $v[0], 0);

        var_dump($x->toJson());
    }
}