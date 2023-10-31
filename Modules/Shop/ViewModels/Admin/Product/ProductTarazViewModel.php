<?php

namespace Modules\Shop\ViewModels\Admin\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Service\Finance\TarazService;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;

class ProductTarazViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function updateTaraz()
    {
        $update = 1;
        $taraz_service = new TarazService();
        $products = $taraz_service->getProductList();
        if ($products){
            $this->updateProductWithTarazRes($products);
        }

        alert()->success(' ','بروزرسانی انجام شد');
        return redirect()->back()->withInput();

    }

    private function updateProductWithTarazRes($tarazres_array){

        foreach ($tarazres_array as $product) {

            $data_product = Product::where('good_id' , $product->goodsID )->first() ?? new Product();

            $data_product->good_id = $product->goodsID;
            $data_product->goodsCode = $product->goodsCode;
            //$data_product->tafsiliID = $product->tafsiliID;
            //$data_product->typeCode = $product->typeCode;
            $data_product->product_code = $product->goodsCode;

            $data_product->price = $product->price1 ?? 0;
            $data_product->qty = $product->remain ?? 0;

            $data_product->good_info = json_encode($product);
            $data_product->save();
        }

    }


    public function updateTarazWithText()
    {
        $this->modelData = new Product();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::taraz.form' ,$data);
    }

    public function updateTarazWithTextSubmit()
    {
        try {
            DB::beginTransaction();

            if ( ! request('codes')){
                alert()->error(' ','کد ها به درستی وارد نشده است ! ');
                return redirect()->back()->withInput();
            }
            $codes = preg_split('/\n|\r\n?/', request('codes'));

            $taraz_service = new TarazService();
            $res_text = '';
            foreach ($codes as $code) {

                $products = $taraz_service->getProductList($code);
                if ($products && count($products) > 0){
                    $this->updateProductWithTarazRes($products);
                    $res_text .="<p class='color-success success'>"."<span>  با موفقیت آپدیت شد   </span>"."<span> ".$code. "</span>".'  کد  ' ."</p>";

                }else{

                    $res_text .="<p class='color-danger danger'>"."<span>  پیدا نشد   </span>"."<span> ".$code. "</span>".'  کد ' ."</p>";
                }
            }

            DB::commit();
            return redirect()->back()->with( ['res_text' => $res_text ] );

        }catch (\Exception $e){

            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();
        }
    }

}
