<?php

namespace Modules\Shop\ViewModels\Front\Compare;

use App\Models\User;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Attribute;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\Entities\ProductCatalogCategoryRel;
use Modules\Shop\Entities\ProductCatalogRel;
use Modules\Shop\Entities\ProductCatalogRelAccessory;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class CompareViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function index()
    {
        $compare = $this->getCompare();
        $products = ProductCatalog::query()->whereIn('id', $compare)->paginate(30);
        $attribute = Attribute::query()->get();
        $data = [
            'view_model' => $this,
            'products' => $products,
            'compare' => $compare,
            'attribute' => $attribute,
        ];

        return $this->renderView('shop::compare.index', $data);
    }

    public function addItem($request)
    {
        $compare = $this->getCompare();
        if (in_array(request('item_id'), $compare)) {
            alert()->toast('این محصول در لیست مقایسه وجود دارد ', 'warning');
            return redirect()->back()->withInput();
        }
        $compare[] = request('item_id');
        session(['compare' => $compare]);

        alert()->toast('اضافه شد', 'success');
        return redirect()->back()->withInput();
    }

    public function removeItem($request)
    {
        $compare = $this->getCompare();
        dd($compare);
        $row_id = $request->cart_row_id;
        $product = Product::find($row_id);
        $current_cart_qty = @ $cart->get($row_id)->quantity ?? 0;

        if ($current_cart_qty == 1) {
            return $this->removeItem($row_id);
        }


        if ($current_cart_qty > $product->qty) {
            $cart->update($row_id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $product->qty,
                ),
            ));
            return redirect()->back()->withInput();
        }
        $cart->update($row_id, array(
            'quantity' => -1,
        ));
        alert()->toast('با موفقیت کاهش یافت', 'success');
        return redirect()->back()->withInput();
    }

    public function getCompare()
    {
        $compare = session()->has('compare') ? session('compare') : [];
        session(['compare' => $compare]);

        return $compare;
    }

    public function remove()
    {
        $productId = request()->input('product_id');

        $compareArray = session('compare');

        $index = array_search($productId, $compareArray);

        if ($index !== false) {
            unset($compareArray[$index]);
            session(['compare' => $compareArray]);
        }
        alert()->toast('محصول مورد نظر شما از لیست مقایسه به موفقیت حذف شد.', 'success');
        return redirect()->back();
    }

}
