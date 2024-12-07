<?php
declare(strict_types=1);

namespace App\Advent\Day6;

use Arrayy\Arrayy as A;
use Tempest\Console\ConsoleCommand;

final readonly class Solver
{
    #[ConsoleCommand('advent:day6-1')]
    public function solve1()
    {
        $input = file_get_contents(__DIR__ . '/input2.txt');
        $field = explode("\n", $input);
        $field = array_map(fn($line) => str_split($line), $field);

        $maxX = 130;
        $maxY = 130;
        $x = 59;
        $y = 71;
//        $maxX = 10;
//        $maxY = 10;
//        $x = 4;
//        $y = 6;
        $rot = [
            0 => [1, 0],
            1 => [0, 1],
            2 => [-1, 0],
            3 => [0, -1],
        ];
        $r = 3;
        do {
            foreach ($field as $row) {
                var_dump( implode("", $row));
            }

            while ($field[$y + $rot[$r][1]][$x + $rot[$r][0]] === '#') {
                $r = ++$r % 4;
                var_dump("Switch r to $r");
            }
            var_dump('------------');

            $x += $rot[$r][0];
            $y += $rot[$r][1];
            if ($x < 0 || $x >= $maxX || $y < 0 || $y >= $maxY) {
                break;
            }

            $field[$y][$x] = 'X';

        } while (true);

        $sum = 0;
        foreach ($field as $row) {
            $sum += count(array_filter($row, fn($chr) => $chr === 'X'));
        }

        file_put_contents(__DIR__.'/input_with_path.txt', array_map(fn($row) => implode($row)."\n", $field));

        var_dump($sum);
    }

    #[ConsoleCommand('advent:day6-2')]
    public function solve2()
    {
        $input = file_get_contents(__DIR__ . '/input_with_path.txt');
        $field = explode("\n", $input);
        $field = array_map(fn($line) => str_split($line), $field);
        $fieldOG = $field;

        $maxX = 130;
        $maxY = 130;
//        $r = 3;
//        $maxX = 10;
//        $maxY = 10;
        $rot = [
            0 => [1, 0],
            1 => [0, 1],
            2 => [-1, 0],
            3 => [0, -1],
        ];
        $obstacles = 0;
        for ($obsX = 0; $obsX < $maxX; $obsX++) {
            for ($obsY = 0; $obsY < $maxY; $obsY++) {
                if ($fieldOG[$obsY][$obsX] !== 'X') {
                    continue;
                }
                if ($obsX === 59 && $obsY === 71) {
                    continue;
                }
                $field = $fieldOG;

                var_dump($obsX, $obsY);
                $field[$obsY][$obsX] = '#';

//                $x = 4;
//                $y = 6;
                $x = 59;
                $y = 71;
                $r = 3;

                $i = 0;
                $repeating = 0;
                do {
//                    $i++;
//                    if ($i >= 5) exit;
                    while ($field[$y + $rot[$r][1]][$x + $rot[$r][0]] === '#') {
                        $r = ++$r % 4;
//                        var_dump("Switch r to $r");
                    }
//                    var_dump('------------');

                    $x += $rot[$r][0];
                    $y += $rot[$r][1];
                    if ($x < 0 || $x >= $maxX || $y < 0 || $y >= $maxY) {
                        break;
                    }
                    if ($field[$y][$x] === 'X') {
                        $repeating++;
                    } else {
                        $field[$y][$x] = 'X';
                    }

                    // not really proud of myself right now xD
                    if ($repeating >= 4*$maxX*$maxY) {
                        $obstacles++;
                        var_dump($obsX, $obsY);
//                        sleep(5);
                        break;
                    }
                } while (true);
            }
        }


        var_dump($obstacles);
    }
}