<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'teacher_id' => $this->teacher_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration' => $this->duration,
            'status' => $this->status,
            'questions' => QuestionBankQuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}
