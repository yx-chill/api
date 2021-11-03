<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function fileUpload($disk, $dir, $file)
	{
		$fileName = Str::random() . '.' . $file->getClientOriginalExtension();

        return Storage::disk($disk)->putFileAs($dir, $file, $fileName);
	}
}
