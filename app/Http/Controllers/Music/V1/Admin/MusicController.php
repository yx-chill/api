<?php

namespace App\Http\Controllers\Music\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Music\Music as MusicReq;
use App\Models\Music\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(MusicReq $request)
	{
		$music = Music::create($request->validated());

		if ($request->hasFile('file')) {
			$music->update([
				'file' => $this->fileUpload('music', 'music', $request->file('file'))
			]);
		}

		return response()->json([
			'status' => true,
			'data' => $music
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Music $music)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Music $music)
	{
		//
	}
}
