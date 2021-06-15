<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name'=> $this->first_name,
            'last_name' =>$this->last_name,
            'email' =>$this->email,
            'phone_number' =>$this->phone_number,
            'department_name' =>$this->department_name,
            'start_date' =>$this->start_date,
            'end_date' =>$this->end_date,

        ];
    }
}
