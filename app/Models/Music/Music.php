<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Music extends Model
{
	protected $table = 'music_musics';
	protected $fillable = [
		'music_type_id',
		'name',
		'composer',
		'file',
		'sort',
		'status'
	];
	protected $cast = [
		'status' => 'boolean'
	];

	public function getFileAttribute($value)
	{
		return Storage::disk('music')->url($value);
	}
}
