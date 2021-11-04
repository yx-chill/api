<?php

namespace App\Http\Resources\Music;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MusicResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'music_type_id' => $this->music_type_id,
			'name' => $this->name,
			'composer' => $this->composer,
			'file' => Storage::disk('music')->url($this->file),
			'image' => $this->image ? Storage::disk('music')->url($this->image) : null,
			'sort' => $this->sort ?? 0,
			'status' => $this->status ?? true,
			'watched' => $this->watched ?? 0
		];
	}
}
