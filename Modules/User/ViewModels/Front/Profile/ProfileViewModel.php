<?php

namespace Modules\User\ViewModels\Front\Profile;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Entities\City;
use Modules\Core\Entities\State;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\ProductCatalog;
use Modules\User\Entities\Department;
use Modules\User\Entities\Ticket;
use Modules\User\Entities\UserFavorite;
use Modules\User\Entities\UserNotifyItem;
use Morilog\Jalali\Jalalian;
use PDF;
use function Psy\debug;

class ProfileViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function index(){
        $this->modelData = new User();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.index' ,$data);

    }

    public function favorite(){
        $products = UserFavorite::query()
            ->where('user_id' , auth()->user()->id )
            ->where('favable_type' , ProductCatalog::class )
            ->get();
        $data = [
            'products' => $products ,
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.favorite' ,$data);
    }
    public function userNotifyItems(){
        $products = UserNotifyItem::query()
            ->where('user_id' , auth()->user()->id )
            ->where('item_type' , ProductCatalog::class )
            ->get();
        $data = [
            'products' => $products ,
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.favorite' ,$data);
    }
    public function payments(){
        $payments = Payment::query()
            ->where('user_id' , auth()->user()->id )
            ->get();

        $data = [
            'payments' => $payments,
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.payments' ,$data);
    }
    public function orders(){
        $orders = Order::query()
            ->where('user_id' , auth()->user()->id )
            ->get();
        $data = [
            'orders' => $orders,
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.orders' ,$data);
    }
    public function address(){
        $addresses = auth()->user()->addresses()->get();
        $states = State::all();

        $stateCityData = [];
        foreach ($states as $state) {
            $cities = City::where('state_id', $state->id)->get()->toArray();
            $stateCityData[] = [
                'state_id' => $state->id,
                'state_name' => $state->name,
                'cities' => $cities,
            ];
        }
        $data = [
            'addresses' => $addresses,
            'stateCityData' => $stateCityData,
            'view_model' => $this,
        ];

        return $this->renderView('user::profile.address', $data);
    }
    public function comments(){
        $comments= UserFavorite::query()
            ->where('user_id' , auth()->user()->id )
            ->where('favable_type' , ProductCatalog::class )
            ->get();

        $data = [
            'comments' => $comments,
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.comments' ,$data);
    }
    public function notifications(){
        $payments = UserFavorite::query()
            ->where('user_id' , auth()->user()->id )
            ->where('favable_type' , ProductCatalog::class )
            ->get();
        $notifications = DatabaseNotification::query()->where('notifiable_id',Auth::id())->get();
        $data = [
            'payments' => $payments,
            'notifications' => $notifications,
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.notifications' ,$data);
    }

    public function editProfile(){
        $this->modelData = User::find(auth()->user()->id);
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.edit-profile' ,$data);
    }
    public function editProfileSubmit($request){
        $validData = $request->validate([
            'name' => 'required|max:255',
            'mobile'=> 'required',
            'email'=> 'required',
            'national_code'=> 'required',
        ]);

        try {
            DB::beginTransaction();
            $model =  User::find(auth()->user()->id);

            $model->fill($validData);
            if ($request->avatar){
                $model->avatar = $this->uploadFile($request , 'avatar' , 'users');
            }
            $model->save();
            DB::commit();

            alert()->toast( 'با موفقیت انجام شد' , 'success' );
            return redirect()->back()->withInput();

        } catch (\Exception $e){

            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();

        }
    }
    public function addItemToFav($request)
    {
        if (! auth()->user() ) {
            alert()->toast('لطفا ابدتا وارد حساب کاربری شوید .','warning' );
            return redirect()->back()->withInput();
        }

        $item_id =   $request->model_id;
        $item_model =  ProductCatalog::class;

        $fav_obj = UserFavorite::where('user_id' , auth()->user()->id)
            ->where('favable_id' , $item_id )
            ->where('favable_type' , $item_model)->first();

        if ( ! $fav_obj){
            // create
            $fav_obj = new UserFavorite() ;
            $fav_obj->user_id = auth()->user()->id;
            $fav_obj->favable_id = $item_id;
            $fav_obj->favable_type = $item_model;
            $fav_obj->save();
            alert()->toast('محصول با موفقیت به علاقه مندی شما اضافه شد ','success' );
        }else{
            // remove
            $fav_obj->delete();
            alert()->toast('محصول از علاقه مندی شما حذف شد ','success' );
        }

        return redirect()->back()->withInput();
    }
    public function addItemToNotify($request)
    {
        if (! auth()->user() ) {
            alert()->toast('لطفا ابدتا وارد حساب کاربری شوید .','warning' );
            return redirect()->back()->withInput();
        }

        $item_id =   $request->model_id;
        $item_model =  ProductCatalog::class;

        $item_obj = UserNotifyItem::where('user_id' , auth()->user()->id)
            ->where('item_id' , $item_id )
            ->where('item_type' , $item_model)->first();

        if ( ! $item_obj){
            // create
            $item_obj = new UserNotifyItem() ;
            $item_obj->user_id = auth()->user()->id;
            $item_obj->item_id = $item_id;
            $item_obj->item_type = $item_model;
            $item_obj->save();
            alert()->toast('محصول با موفقیت به لیست اطلاع رسانی اضافه شد ','success' );
        }else{
            // remove
            $item_obj->delete();
            alert()->toast('محصول از لیست اطلاع رسانی شما حذف شد ','success' );
        }

        return redirect()->back()->withInput();
    }

    public function ordersShow()
    {
        $order = Order::query()
            ->where('user_id' , auth()->user()->id )
            ->where('id' , request('model_id') )
            ->first();

        $data = [
            'order' => $order,
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.show-order' ,$data);

    }

    public function ordersPdf()
    {

        $order = Order::query()
            ->where('user_id' , auth()->user()->id )
            ->where('id' , request('model_id') )
            ->first();

        $user = User::find($order->user_id);

        $data = [
            'order' => $order,
            'user' => $user,
            'view_model' => $this,
        ];

        $pdf = PDF::loadView('pdf.order', $data);

        return $pdf->download('order-'.$order->id.'-'.now().'.pdf');

    }

    public function tickets()
    {
        $tickets = Ticket::query()->with('user')->where('user_id',Auth::id())->orderByDesc('created_at')->get();
        $data = [
            'tickets' => $tickets,
        ];
        return $this->renderView('user::profile.tickets' ,$data);

    }

    public function ticketShow()
    {
        $ticket = Ticket::query()->with('ticketAnswers')->findOrFail(request()->ticket_id);
        $data = [
            'ticket' => $ticket,
        ];
        return $this->renderView('user::profile.showTicket' ,$data);

    }

    public function createTicket()
    {
        $departments = Department::all();
        $data = [
            'departments' => $departments
        ];
        return $this->renderView('user::profile.createTicket' ,$data);
    }

    public function storeTicket()
    {
        try {
            DB::beginTransaction();

            $ticket = new Ticket();
            $ticket->title = request()->input('title');
            $ticket->description = request()->input('description');
            $ticket->user_id = Auth::id();
            $ticket->department_id = request()->input('department_id');
            $ticket->status = 'open';
            $ticket->save();

            DB::commit();

            alert()->toast( 'پیام شما با موفقیت ارسال شد.' , 'success' );
            return redirect()->route('front.user.profile.tickets');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'متاسفانه خطایی در ایجاد پیام رخ داده است.');
        }
    }

}
