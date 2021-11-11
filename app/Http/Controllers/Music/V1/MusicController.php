<?php

namespace App\Http\Controllers\Music\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Music\MusicResource;
use App\Models\Music\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{
	public function index(Request $request)
	{
		// 取得搜尋字串
		$search = $request->input('search', '');

		// 每頁筆數
		$limit = (int) $request->input('limit', 18);

		return MusicResource::collection(
			Music::with(['musicType' => function ($query) {
				$query->select(['id', 'name'])->where('status', true);
			}])->when($search, function ($query) use ($search) {
				$query->where('name', 'like', "%{$search}%")->orWhere('composer', 'like', "%{$search}%");
			})->where('status', true)->orderBy('sort')->paginate($limit)->withQueryString()
		);
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
