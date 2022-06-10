<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;

class MainController extends Controller
{
    protected $sliderService;
    protected $menu;
    protected $product;
    public function __construct(SliderService $sliderService, MenuService $menu, ProductService $product)
    {
        $this->sliderService = $sliderService;
        $this->menu = $menu;
        $this->product = $product;
    }

    public function index()
    {
        return view('main', [
            'title' => 'Home Page',
            'sliders' => $this->sliderService->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->get()
        ]);
    }
    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->get($page);
        if (count($result) != 0) {
            $html = view('products.list', ['products' => $result])->render();

            return response()->json(['html' => $html]);
        }

        return response()->json(['html' => '']);
    }
}
