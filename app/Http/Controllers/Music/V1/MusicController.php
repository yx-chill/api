<?php

namespace App\Http\Controllers\Music\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Music\MusicResource;
use App\Models\Music\Music;

class MusicController extends Controller
{
	public function index()
	{
		//  TODO: 分頁、搜尋...
		return response()->json([
			'status' => true,
			'data' => MusicResource::collection(
				Music::with('musicType:id,name')->where('status', true)->orderBy('sort')->get()
			)
		]);
	}

	public function show(Music $music)
	{
		$music->load('musicType');

		if (!$music->status || !$music->musicType->status) {
			return response()->json([
				'status' => false,
				'message' => '資料不存在'
			]);
		}

		$music->increment('watched');

		return response()->json([
			'status' => true,
			'data' => new MusicResource($music)
		]);
	}
}
