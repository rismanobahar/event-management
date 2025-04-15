<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     // the following code is used to return only the fields that are needed
    public function toArray(Request $request): array
    {
        return parent::toArray($request); // Return the user data as an array and returning all the fields
    }
}
