<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionBankQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_text' => $this->question_text,
            'type' => $this->type,
            'default_mark' => $this->default_mark,
            'difficulty' => $this->difficulty,
            'teacher_id' => $this->teacher_id,
            'status' => $this->status,
            'categories' => QuestionCategoryResource::collection($this->whenLoaded('categories')),
            'pivot' => $this->whenPivotLoaded('assessment_question', function () {
                return [
                    'mark' => $this->pivot->mark,
                    'order' => $this->pivot->order,
                ];
            }),
        ];
    }
}
