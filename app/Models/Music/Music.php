<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
	protected $table = 'music_musics';
	protected $fillable = [
		'music_type_id',
		'name',
		'sort',
		'status'
	];
	protected $cast = [
		'status' => 'boolean'
	];
}
