<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Message;
use App\Models\User;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $count = Message::where([
            ['from_id', $this->from_id],
            ['to_id', $this->to_id],
        ])->whereNull('read_at')->count();


        return [
            'id' => $this->users->id,
            'email' => $this->users->email,
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'count' => $count
        ];
    }
}
