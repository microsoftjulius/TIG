<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MessagesCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id'          => $this->id,
            'message'     => $this->message,
            'group_id'    => $this->group_id,
            'church_id'   => $this->church_id,
            'category_id' => $this->category_id,
            'created_by'  => $this->id,
            'href'  => [
                'link' => route('messages.show',$this->id)
            ]
        ];
    }
}
