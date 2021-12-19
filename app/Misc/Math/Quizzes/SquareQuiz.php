<?php

namespace App\Misc\Math\Quizzes;

use App\Misc\Math\MathQuiz;

class SquareQuiz extends MathQuiz
{
    const PARAM_N = 'n';

    const PARAM_N_MIN = 0;
    const PARAM_N_MAX = 100;

    public function solve(): void
    {
        $n = $this->get(self::PARAM_N);

        for ($i = 1, $sumOfSquares = 0, $squareOfSums = 0; $i <= $n; $i++)
        {
            $sumOfSquares += $i * $i;
            $squareOfSums += $i;
        }

        $squareOfSums *= $squareOfSums;

        $this->setResult([$squareOfSums - $sumOfSquares]);
    }

    public function validate(): void
    {
        if (!$this->exists(self::PARAM_N))
        {
            self::error(self::PARAM_N, 'param `' . self::PARAM_N . '` is missing');
        }


        $n = $this->get(self::PARAM_N);

        if (!is_integer($n) or $n < self::PARAM_N_MIN or $n > self::PARAM_N_MAX)
        {
            self::error(self::PARAM_N, 'param `' . self::PARAM_N . '` must be an integer in the range ' . self::PARAM_N_MIN . '..' . self::PARAM_N_MAX);
        }
    }
}
