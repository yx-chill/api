<?php

namespace App\Http\Controllers\Music\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Music\MusicResource;
use App\Models\Music\Music;
use App\Models\Music\MusicLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MusicController extends Controller
{
	public function index(Request $request)
	{
		// 取得搜尋字串
		$search = $request->input('search', '');

		// 排序欄位
		$orderBy = $request->input('order', 'sort');

		// 升降冪
		$sort = $request->input('sort', 'asc');

		// 每頁筆數
		$limit = (int) $request->input('limit', 18);

		return MusicResource::collection(
			Music::withCount('musicLikes')->with('musicType:id,name')
				->whereHas('musicType', function ($query) {
					$query->where('status', true);
				})
				->when($search, function ($query) use ($search) {
					$query->where('name', 'like', "%{$search}%")->orWhere('composer', 'like', "%{$search}%");
				})
				->where('status', true)->orderBy($orderBy, $sort)->paginate($limit)->withQueryString()
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

	public function like(Music $music)
	{
		$user = Auth::user();

		if (MusicLike::where('user_id', $user->id)->where('music_id', $music->id)->doesntExist()) {
			$music->musicLikes()->create([
				'user_id' => $user->id
			]);
		}

		return response()->json([
			'status' => true,
			'message' => 'Success'
		]);
	}

	public function unlike(Music $music)
	{
		MusicLike::where('user_id', Auth::user()->id)->where('music_id', $music->id)->delete();

		return response()->json([
			'status' => true,
			'message' => 'Success'
		]);
	}

	public function likeList(Request $request)
	{
		$user = Auth::user();

		// 每頁筆數
		$limit = (int) $request->input('limit', 18);

		return MusicResource::collection(
			Music::with(['musicLikes', 'musicType:id,name'])->whereHas('musicLikes', function ($query) use ($user) {
				$query->where('user_id', $user->id);
			})->whereHas('musicType', function ($query) {
					$query->where('status', true);
				})->where('status', true)->orderBy('sort')->paginate($limit)->withQueryString()
		);
	}
}
