<?php

namespace Modules\Core\Http\Controllers\Admin\dropzone;

use App\Http\Controllers\Controller;
use Faker\Core\Uuid;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Entities\Image;
use Modules\Core\ViewModels\MasterViewModel;
use mysql_xdevapi\Exception;

class DropZoneController extends Controller
{
    public function upload(Request $request)
    {
        $image = new Image();


        $photo = \stdClass();

        $photo->image =  $this->SaveImage($request->file('file'), 'products', 'p');
        $photo->alt = '-';
        $photo->productId =  $request->productId;
        return response()->json([
            'photo_id' => $photo->id,
            'message' => 'Image saved Successfully',
        ], 200);

    }
    public static function SaveImage($file, $path,$imageable_type , $imageable_id , $prefix , $alt = '' )
    {
        try {

            $fileName = $prefix . rand(1000 , 909999) .'-'. time() .'-'. rand(1000 , 909999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('image/' . $path), $fileName);
            $path =  "/image/" . $path . "/" . $fileName;
            $image = new Image();
            $image->imageable_type = $imageable_type ;
            $image->imageable_id = $imageable_id ;
            $image->src = $path ;
            $image->alt = $alt ;
            $image->save();
            return $image ;
        } catch (\Throwable $th) {
            throw new Exception($th);
        }
    }

    public function remove(Image $id)
    {
        $id->delete();
        return redirect()->back()->withInput();

    }

}
