<?php
declare(strict_types=1);

namespace App\Advent\Day4;

use Arrayy\Arrayy as A;
use Arrayy\Type\StringCollection;
use Tempest\Console\ConsoleCommand;

final readonly class Solver
{
    private array $lines;
    private int $size;

    #[ConsoleCommand('advent:day4-1')]
    public function solve1(): void
    {
        $input = file_get_contents(__DIR__ . '/input2.txt');
        $this->lines = A::create(explode("\n", $input))->map(fn($line) => str_split($line))->toArray();
        $this->size = count($this->lines[0]);

        $sum = 0;
        for ($y = 0; $y < $this->size; $y++) {
            for ($x = 0; $x < $this->size; $x++) {
                $sum += $this->findXMAS($x, $y, 1, 0) ? 1 : 0;
                $sum += $this->findXMAS($x, $y, -1, 0) ? 1 : 0;
                $sum += $this->findXMAS($x, $y, 0, 1) ? 1 : 0;
                $sum += $this->findXMAS($x, $y, 0, -1) ? 1 : 0;
                $sum += $this->findXMAS($x, $y, 1, 1) ? 1 : 0;
                $sum += $this->findXMAS($x, $y, -1, -1) ? 1 : 0;
                $sum += $this->findXMAS($x, $y, 1, -1) ? 1 : 0;
                $sum += $this->findXMAS($x, $y, -1, 1) ? 1 : 0;
            }
        }

        var_dump($sum);
    }

    #[ConsoleCommand('advent:day4-2')]
    public function solve2(): void
    {
        $input = file_get_contents(__DIR__ . '/input2.txt');
        $this->lines = A::create(explode("\n", $input))->map(fn($line) => str_split($line))->toArray();
        $this->size = count($this->lines[0]);

        $sum = 0;
        for ($y = 0; $y < $this->size; $y++) {
            for ($x = 0; $x < $this->size; $x++) {
                $sum += $this->findX_MAS($x, $y, ['M', 'M', 'S', 'S']);
                $sum += $this->findX_MAS($x, $y, ['S', 'M', 'M', 'S']);
                $sum += $this->findX_MAS($x, $y, ['S', 'S', 'M', 'M']);
                $sum += $this->findX_MAS($x, $y, ['M', 'S', 'S', 'M']);
            }
        }

        var_dump($sum);
    }

    private function findXMAS(int $x, int $y, int $dirx, int $diry): bool
    {
        if ($x + 3 * $dirx < 0 || $x + 3 * $dirx >= $this->size
            || $y + 3 * $diry < 0 || $y + 3 * $diry >= $this->size) {
            return false;
        }

        if ($this->lines[$y][$x] === 'X'
            && $this->lines[$y + $diry][$x + $dirx] === 'M'
            && $this->lines[$y + 2*$diry][$x + 2*$dirx] === 'A'
            && $this->lines[$y + 3*$diry][$x + 3*$dirx] === 'S'
        ) {
            return true;
        }
        return false;
    }

    private function findX_MAS(int $x, int $y, array $set): bool
    {
        if ($x + 2 >= $this->size || $y + 2 >= $this->size) {
            return false;
        }


        if ($this->lines[$y][$x] === $set[0]
            && $this->lines[$y + 2][$x] === $set[1]
            && $this->lines[$y + 2][$x + 2] === $set[2]
            && $this->lines[$y][$x + 2] === $set[3]
            && $this->lines[$y + 1][$x + 1] === 'A'
        ) {
            return true;
        }
        return false;
    }
}