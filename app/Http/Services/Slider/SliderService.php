<?php

namespace App\Http\Services\Slider;

use App\Models\Slider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    public function insert($request)
    {
        try {
            $input = $request->all();
            if ($request->hasFile('image')) {
                $destination_path = 'public/images';
                $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('image')->storeAs($destination_path, $image_name);
                $input['image'] = $image_name;
            }
            Slider::create($input);
            $request->except('_token');
            Session::flash('success', 'Thêm Slider thành công!');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Slider lỗi!');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }
    public function getList()
    {
        return Slider::orderByDesc('id')->paginate(15);
    }
    public function update($request, $slider)
    {
        try {
            $input = $request->input();
            if ($request->hasFile('image')) {
                $destination_path = 'public/images';
                $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('image')->storeAs($destination_path, $image_name);
                $input['image'] = $image_name;
            }
            $slider->fill($input);
            $slider->save();
            Session::flash('success', 'Cập nhật Slider thành công!');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật Slider lỗi!');
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $id = (int)$request->input('id');
        $slider = Slider::where('id', $id)->first();
        if ($slider) {
            Storage::delete('images/' . $slider->image);
            $slider->delete();
            return true;
        }
        return false;
    }

    public function show()
    {
        return Slider::where('active', 1)->orderByDesc('sort_by')->get();
    }
}
