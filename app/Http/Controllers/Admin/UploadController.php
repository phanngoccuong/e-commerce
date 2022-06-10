<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UploadService;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;

class UploadController extends Controller
{
    protected $upload;

    public function __construct(UploadService $upload)
    {
        $this->upload = $upload;
    }

    public function store(Request $request)
    {
        // $url = $this->upload->store($request);
        // if ($url !== false) {
        //     return response()->json([
        //         'error' => false,
        //         'url'   => $url
        //     ]);
        // }

        // return response()->json(['error' => true]);
        // request()->validate([
        //     'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        // if ($files = $request->file('thumb')) {

        //     $fileName =  "thumb-" . time() . '.' . $request->thumb->getClientOriginalExtension();
        //     $request->thumb->storeAs('thumb', $fileName);

        //     $thumb = new Product;
        //     $thumb->thumb = $fileName;
        //     $thumb->save();

        //     return Response()->json([
        //         "thumb" => $fileName
        //     ], Response::HTTP_OK);
        // }
    }
}
