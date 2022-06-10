<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use Illuminate\Http\Request;
use  App\Http\Requests\Slider\SliderRequest;
use App\Models\Slider;

class SliderController extends Controller
{
    protected $sliderService;
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function create()
    {
        return view('admin.slider.add', [
            'title' => 'Thêm Slider mới'
        ]);
    }
    public function store(SliderRequest $request)
    {
        $this->sliderService->insert($request);
        return redirect()->back();
    }
    public function index()
    {
        return view('admin.slider.list', [
            'title' => 'Slider List',
            'sliders' => $this->sliderService->getList()
        ]);
    }
    public function show(Slider $slider)
    {
        return view('admin.slider.edit', [
            'title' => 'Chỉnh sửa SLider',
            'slider' => $slider,
        ]);
    }
    public function update(Request $request, Slider $slider)
    {
        $result =  $this->sliderService->update($request, $slider);
        if ($result) {
            return redirect('admin/sliders/list');
        }
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $result = $this->sliderService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Đã xóa thành công'
            ]);
        }
        return response()->json([
            'error' => true,
        ]);
    }
}
