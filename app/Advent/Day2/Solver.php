<?php
declare(strict_types=1);

namespace App\Advent\Day2;

use Arrayy\Arrayy as A;
use Tempest\Console\ConsoleCommand;

final readonly class Solver
{
    #[ConsoleCommand('advent:day2-1')]
    public function solve1()
    {
        $input = file_get_contents(__DIR__ . '/input1.txt');
        $lines = explode("\n", $input);

        $inner = function($carry, $value) {
            if ($carry['prev'] === null) {
                $carry['prev'] = $value;
                return $carry;
            }
            $carry['i'] = ($carry['i'] ?? true) && ($carry['prev'] < $value) && abs($carry['prev'] - $value) <= 3;
            $carry['d'] = ($carry['d'] ?? true) && ($carry['prev'] > $value) && abs($carry['prev'] - $value) <= 3;
            $carry['prev'] = $value;
            return $carry;
        };

        $data = A::create($lines)->map(fn($line) => explode(" ", $line))->map(function(array $row) use ($inner) {
            return A::create($row)->reduce($inner(...), ['d' => null, 'i' => null, 'prev' => null]);
        })->reduce(fn($sum, $row) => $sum + (($row['d'] || $row['i']) ? 1 : 0) , 0);

        var_dump($data->toJson());
    }

    #[ConsoleCommand('advent:day2-2')]
    public function solve2()
    {
        $input = file_get_contents(__DIR__ . '/input2.txt');
        $lines = explode("\n", $input);


        $inner = function($carry, $value) {
            if ($carry['prev'] === null) {
                $carry['prev'] = $value;
                return $carry;
            }

            $carry['i'] = ($carry['i'] ?? true) && ($carry['prev'] < $value) && abs($carry['prev'] - $value) <= 3;
            $carry['d'] = ($carry['d'] ?? true) && ($carry['prev'] > $value) && abs($carry['prev'] - $value) <= 3;
            $carry['prev'] = $value;
            return $carry;
        };

        $data = A::create($lines)
            ->map(fn($line) => A::create(explode(" ", $line)))
            ->map(function(A $row) use ($inner) {
                $result = [];
                // BRUTEFORCE THAT SHIT
                foreach ($row as $key => $value) {
                    $rowCopy = clone $row;
                    unset($rowCopy[$key]);
                    $result = A::create($rowCopy)->reduce($inner(...), ['d' => null, 'i' => null, 'prev' => null]);
                    if ($result['d'] || $result['i']) {
                        return $result;
                    }
                }
                return $result;
            })
            ->reduce(fn($sum, $row) => $sum + (($row['d'] || $row['i']) ? 1 : 0) , 0);

        var_dump($data->toJson());
    }
}