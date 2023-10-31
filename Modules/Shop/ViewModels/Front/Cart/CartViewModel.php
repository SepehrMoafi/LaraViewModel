<?php

namespace Modules\Shop\ViewModels\Front\Cart;

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
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\Entities\ProductCatalogCategoryRel;
use Modules\Shop\Entities\ProductCatalogRel;
use Modules\Shop\Entities\ProductCatalogRelAccessory;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class CartViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function index()
    {
        $products = ProductCatalog::query()->paginate(30);

        $cart = $this->getCart();

        $data = [
            'view_model' => $this,
            'view_model2' => new CheckoutViewModel(),
            'products' => $products,
            'cart'=> $cart,
        ];

        return $this->renderView('shop::cart.index' ,$data);
    }

    public function increaseQty($request)
    {
        $cart = $this->getCart();

        $row_id = $request->cart_row_id;
        $product = Product::find($row_id);
        $current_cart_qty = @ $cart->get($row_id)->quantity ?? 0;
        if ($current_cart_qty >= $product->qty ){
            alert()->toast('موجودی کالا کافی نیست ','error' );
            $cart->update($row_id, array(
                'quantity'  => array(
                    'relative' => false,
                    'value' => $product->qty,
                ),
            ));
            return redirect()->back()->withInput();
        }
        $cart->update($row_id, array(
            'quantity' => 1,
        ));
        alert()->toast('اضافه شد','success' );
        return redirect()->back()->withInput();
    }

    public function decreaseQty($request)
    {
        $cart = $this->getCart();

        $row_id = $request->cart_row_id;
        $product = Product::find($row_id);
        $current_cart_qty = @ $cart->get($row_id)->quantity ?? 0;

        if ($current_cart_qty == 1){
            return $this->removeItem($row_id);
        }


        if ($current_cart_qty > $product->qty ){
            $cart->update($row_id, array(
                'quantity'  => array(
                    'relative' => false,
                    'value' =>$product->qty,
                ),
            ));
            return redirect()->back()->withInput();
        }
        $cart->update($row_id, array(
            'quantity' => -1,
        ));
        alert()->toast('با موفقیت کاهش یافت','success' );
        return redirect()->back()->withInput();
    }


    public function addProductToCart($request)
    {
        $cart = $this->getCart();

        if ( ! request('color')){
            alert()->toast('لطفا یک رنگ را انتخاب کنید','warning' );
            return redirect()->back()->withInput();
        }
        if ( ! request('qty')){
            alert()->toast('لطفا تعداد را وارد کنید','warning' );
            return redirect()->back()->withInput();
        }

        $row_id = request('color');
        $product = Product::find($row_id);
        $current_cart_qty = @ $cart->get($row_id)->quantity ?? 0;
        $current_cart_qty += request('qty');
        if ($current_cart_qty > $product->qty ){
            alert()->toast('موجودی کالا کافی نیست ','error' );
            return redirect()->back()->withInput();
        }

        $cart->add($product->id, $product->catalog->title, $product->price , request('qty') , array('image' => $product->catalog->image , 'color' => $product->color , 'warranty' => $product->warranty , 'catalog'=>$product->catalog , 'product'=> $product ));

        alert()->toast('محصول با موفقیت به سبد خرید شما اضافه شد ','success' );
        return redirect()->back()->withInput();
    }

    public function removeItem($item_id){
        $cart = $this->getCart();
        $cart->remove($item_id);
        alert()->toast('با موفقیت حذف شد','success' );
        return redirect()->back()->withInput();
    }


    public function getCart(){

        if ( auth()->user() ) {
            $cart_key = session()->has('cart_key') ? session('cart_key') : auth()->user()->id;
        } else {
            $cart_key = session()->has('cart_key') ? session('cart_key') : rand(1000000 , 9099999999999);
            session(['cart_key' => $cart_key ]);
        }

        return CartViewModel::updateCartItems(\Cart::session($cart_key));

    }

    public static function updateCartItems( $cart)
    {

        //TODO update
        return $cart;

    }
}
