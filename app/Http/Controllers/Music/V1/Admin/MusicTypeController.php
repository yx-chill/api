<?php

namespace App\Http\Controllers\Music\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Music\MusicType as MusicTypeReq;
use App\Http\Resources\Music\MusicTypeResource;
use App\Models\Music\MusicType;

class MusicTypeController extends Controller
{
	public function index()
	{
		return response()->json([
			'status' => true,
			'data' => MusicTypeResource::collection(MusicType::get())
		]);
	}

	public function store(MusicTypeReq $request)
	{
		return response()->json([
			'status' => true,
			'data' => MusicType::create($request->validated())
		]);
	}

	public function update(MusicTypeReq $request, $id)
	{
		$musicType = MusicType::find($id);

		if (!$musicType) {
			return response()->json([
				'status' => false,
				'message' => '資料不存在'
			], 404);
		}

		$musicType->update($request->validated());

		return response()->json([
			'status' => true,
			'data' => $musicType
		]);
	}

	public function destroy($id)
	{
		$musicType = MusicType::with('musics')->find($id);

		if (!$musicType) {
			return response()->json([
				'status' => false,
				'message' => '資料不存在'
			], 404);
		}

		if ($musicType->musics->isNotEmpty()) {
			return response()->json([
				'status' => false,
				'message' => '尚有關聯資源，無法刪除'
			], 400);
		}

		MusicType::destroy($id);

		return response()->json([
			'status' => true
		]);
	}
}
