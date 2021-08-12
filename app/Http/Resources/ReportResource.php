<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use app\Models\Report;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $count = Report::where([
            ['from_id', $this->from_id],
        ])->whereNull('read_at')->count();


        return [
            'id' => $this->users->id,
            'email' => $this->users->email,
            'from_id' => $this->from_id,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'count' => $count
        ];
    }
}
