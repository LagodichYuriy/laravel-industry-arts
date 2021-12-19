<?php

namespace App\Http\Requests\API;

use App\Http\Requests\ApiRequest;
use App\Misc\Math\Quizzes\SquareQuiz;

class QuizzesSquareRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            SquareQuiz::PARAM_N => 'required|integer|min:' . SquareQuiz::PARAM_N_MIN . '|max:' . SquareQuiz::PARAM_N_MAX,
        ];
    }
}
