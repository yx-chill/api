<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Model;

class MusicType extends Model
{
	protected $table = 'music_music_types';
	protected $fillable = [
		'name',
		'sort',
		'status'
	];
	protected $cast = [
		'status' => 'boolean'
	];

	public function musics()
	{
		return $this->hasMany(Music::class);
	}
}