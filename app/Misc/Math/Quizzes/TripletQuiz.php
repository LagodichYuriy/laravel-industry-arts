<?php

namespace App\Misc\Math\Quizzes;

use App\Misc\Math\MathQuiz;

class TripletQuiz extends MathQuiz
{
    const PARAMS = [self::PARAM_A, self::PARAM_B, self::PARAM_C];

    const PARAM_A = 'a';
    const PARAM_B = 'b';
    const PARAM_C = 'c';

    const PARAM_ANY_MIN = 1;
    const PARAM_ANY_MAX = 1000;
    const PARAM_ALL_MAX = 1000;

    public function solve(): void
    {
        [$a, $b, $c] = $this->getBulk(self::PARAMS);

        $isPythagorean = ($a * $a) + ($b * $b) == $c * $c;

        $n = $a * $b * $c;

        $this->setResult([$isPythagorean, $a, $b, $c, $n]);
    }

    public function validate(): void
    {
        foreach (self::PARAMS as $param)
        {
            if (!$this->exists($param))
            {
                self::error($param, "param `$param` is missing");
            }


            $number = $this->get($param);

            if (!is_integer($number) or $number < self::PARAM_ANY_MIN or $number > self::PARAM_ANY_MAX)
            {
                self::error($param, "param `$number` must be an integer in the range " . self::PARAM_ANY_MIN . '..' . self::PARAM_ANY_MAX);
            }
        }


        [$a, $b, $c] = $this->getBulk(self::PARAMS);

        if ($a * $b * $c > self::PARAM_ALL_MAX)
        {
            self::error(null, 'the product of the sequence must be no greater than ' . self::PARAM_ALL_MAX);
        }
    }
}
