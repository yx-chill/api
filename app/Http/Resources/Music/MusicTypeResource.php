<?php

namespace App\Http\Resources\Music;

use Illuminate\Http\Resources\Json\JsonResource;

class MusicTypeResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'sort' => $this->sort ?? 0,
			'status' => $this->status ?? true
		];
	}
}
