<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'type' => 'ticket',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                    $request->routeIs('tickets.show'),
                    $this->description
                ),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => route(
                    'tickets.show',
                    ['ticket' => $this->id]
                )
            ],
            'includes' => [
                new UserResource($this->user),
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ],
                    'links' => [
                        'self' => 'todo'
                    ]
                ]
            ]
        ];
    }
}
