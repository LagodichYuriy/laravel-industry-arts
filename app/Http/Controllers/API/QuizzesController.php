<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\QuizzesSquareRequest;
use App\Http\Requests\API\QuizzesTripletRequest;
use App\Http\Resources\QuizResource;
use App\Misc\Math\Quizzes\SquareQuiz;
use App\Misc\Math\Quizzes\TripletQuiz;
use Illuminate\Http\JsonResponse;

class QuizzesController extends Controller
{
    public function square(QuizzesSquareRequest $request): QuizResource
    {
        $n = (int) $request->get(SquareQuiz::PARAM_N);

        $quiz = new SquareQuiz([SquareQuiz::PARAM_N => $n]);

        [$value] = $quiz->getResult();

        return new QuizResource
        ([
            'value'       => $value,
            'number'      => $n,
            'occurrences' => $quiz->hits()
        ]);
    }

    public function triplet(QuizzesTripletRequest $request): QuizResource
    {
        $payload =
        [
            TripletQuiz::PARAM_A => (int) $request->get(TripletQuiz::PARAM_A),
            TripletQuiz::PARAM_B => (int) $request->get(TripletQuiz::PARAM_B),
            TripletQuiz::PARAM_C => (int) $request->get(TripletQuiz::PARAM_C)
        ];

        $quiz = new TripletQuiz($payload);

        [$isPythagorean, $a, $b, $c, $n] = $quiz->getResult();

        return new QuizResource
        ([
            'a' => $a,
            'b' => $b,
            'c' => $c,
            'n' => $n,

            'is_pythagorean' => $isPythagorean,
            'occurrences'    => $quiz->hits()
        ]);
    }
}
