<?php

namespace App\Http\Resources;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created' => Carbon::parse($this->created_at)->format('h:m:s d/m/Y'),
            'property' => [
                'parent_id' => $this->parent_id,
                'status' => $this->status,
                'priority' => $this->priority,
                'completed' => Carbon::parse($this->completedAt)->format('h:m:s d/m/Y'),
            ],
            'sub_tasks' => TaskResource::collection(Task::where('parent_id', $this->id)->get()),
            'owner' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'name' => $this->user->name,
            ]
        ];
    }
}
