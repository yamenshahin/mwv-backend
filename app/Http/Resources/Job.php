<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Feedback;
use App\JobMeta;
use App\Http\Resources\UserSimple as UserSimpleResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\JobMeta as JobMetaResource;
use App\Http\Resources\JobFeedback as JobFeedbackResource;

class Job extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($this->status === 'booked') {
            $driver = UserResource::make(User::find($this->user_id));
            $moving_date = JobMeta::select('value')
            ->where([
                ['job_id', '=', $this->id],
                ['key', '=', 'movingDate']
            ])
            ->first();
            $moving_date =  strtotime($moving_date->value);
            $today =  strtotime(date('c'));
            $intervalSec = $today - $moving_date;
            if($intervalSec/ 3600 > 24) {
                $feedback = JobFeedbackResource::make(
                    Feedback::select('*')
                    ->where('owner_id', '=', $this->id)
                    ->first()
                );
            } else {
                $feedback = 0;
            }
            
        } else {
            $driver = UserSimpleResource::make(User::find($this->user_id));
            $feedback = 0;
        }
        
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'driver' => $driver,
            'status' => $this->status,
            'feedback'=> $feedback,
            'job_metas' => JobMetaResource::collection($this->meta)
        ];
    }
}
