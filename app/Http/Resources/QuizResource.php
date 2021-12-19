<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        # default values are ignored if same keys are presented in $data array[
        return parent::toArray($request) +
        [
            'datetime'    => time(),
            'occurrences' => 0
        ];
    }
}
