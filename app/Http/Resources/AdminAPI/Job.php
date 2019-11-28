<?php

namespace App\Http\Resources\AdminAPI;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Http\Resources\AdminAPI\User as UserResource;
use App\Http\Resources\AdminAPI\JobMeta as JobMetaResource;
use App\Feedback;
use App\Http\Resources\AdminAPI\FeedbackJob as FeedbackJobResource;
use App\JobMeta;

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
        //return parent::toArray($request);
        $customer = UserResource::make(User::find($this->customer_id));
        if(!$customer['id']) {
            $customerInfoName = JobMeta::select('*')
            ->where([
                ['job_id', '=', $this->id],
                ['key', '=', 'customerInfoName']
            ])
            ->first();
            $customerInfoEmail = JobMeta::select('*')
            ->where([
                ['job_id', '=', $this->id],
                ['key', '=', 'customerInfoEmail']
            ])
            ->first();
            $customerInfoPhone = JobMeta::select('*')
            ->where([
                ['job_id', '=', $this->id],
                ['key', '=', 'customerInfoPhone']
            ])
            ->first();

            $customer = [
                'id' =>  '0',
                'name' => $customerInfoName->value,
                'email' => $customerInfoEmail->value,
                'phone' => $customerInfoPhone->value,
                'role' => 'not registered',
                'status' => 'not registered',
            ];
        }
        $feedback = FeedbackJobResource::make(
            Feedback::select('*')
            ->where('owner_id', '=', $this->id)
            ->first()
        );
        if(!$feedback['status']) {
            $feedback = [
                'id' =>  0,
                'comment' => '',
                'stars' => 5,
                'status' => 'active',
            ];
        }
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'driver' => UserResource::make(User::find($this->user_id)),
            'customer' => $customer,
            'status' => $this->status,
            'job_metas' => JobMetaResource::collection($this->meta),
            'feedback' => $feedback,
        ];
    }
}
