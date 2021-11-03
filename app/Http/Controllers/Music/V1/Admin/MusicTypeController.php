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

	public function update(MusicTypeReq $request, MusicType $musicType)
	{
		$musicType->update($request->validated());

		return response()->json([
			'status' => true,
			'data' => $musicType
		]);
	}

	public function destroy(MusicType $musicType)
	{
		return response()->json([
			'status' => $musicType->delete()
		]);
	}
}
