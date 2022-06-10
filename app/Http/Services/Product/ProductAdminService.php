<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    protected function isValidPrice($request)
    {
        if (
            $request->input('price') > 0 && $request->input('price_sale') > 0
            && $request->input('price') <= $request->input('price_sale')
        ) {
            Session::flash('error', 'Giá Sale phải thấp hơn giá gốc');
            return false;
        }

        if ($request->input('price') == 0 && $request->input('price_sale') != 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }
        return true;
    }

    public function insert($request)

    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) {
            return false;
        }
        try {
            $input = $request->all();
            if ($request->hasFile('image')) {
                $destination_path = 'public/images';
                $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('image')->storeAs($destination_path, $image_name);
                $input['image'] = $image_name;
            }
            Product::create($input);
            $request->except('_token');
            Session::flash('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm sản phẩm lỗi!');
            return false;
        }
        return true;
    }

    public function getList()
    {
        return Product::with('menu')->orderbyDesc('id')->paginate(15);
    }

    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) {
            return false;
        }
        try {
            $input = $request->input();
            if ($request->hasFile('image')) {
                $destination_path = 'public/images';
                $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('image')->storeAs($destination_path, $image_name);
                $input['image'] = $image_name;
            }
            $product->fill($input);
            $product->save();
            Session::flash('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật sản phẩm lỗi!');
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $id = (int)$request->input('id');
        $product = Product::where('id', $id)->first();
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
