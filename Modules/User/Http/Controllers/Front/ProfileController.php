<?php

namespace Modules\User\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class ProfileController
{

    public function index(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('index')
            ->render();
    }
    public function favorite(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('favorite')
            ->render();
    }

    public function userNotifyItems(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('userNotifyItems')
            ->render();
    }

    public function payments(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('payments')
            ->render();
    }

    public function orders(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('orders')
            ->render();
    }

    public function ordersShow($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.profile.profile')
            ->setAction('ordersShow')
            ->render();
    }
    public function ordersRepay($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.payment.payment')
            ->setAction('ordersRepay')
            ->render();
    }
    public function ordersPdf($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.profile.profile')
            ->setAction('ordersPdf')
            ->render();
    }

    public function address(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('address')
            ->render();
    }
    public function comments(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('comments')
            ->render();
    }
    public function notifications(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('notifications')
            ->render();
    }

    public function editProfile(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('editProfile')
            ->render();
    }

    public function editProfileSubmit( Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['a' => 'd' ] )
            ->setViewModel('front.profile.profile')
            ->setAction('editProfileSubmit')
            ->render();
    }

    public function addItemToFav($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.profile.profile')
            ->setAction('addItemToFav')
            ->render();
    }

    public function addItemToNotify($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.profile.profile')
            ->setAction('addItemToNotify')
            ->render();
    }

    public function companyRegister_1(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['a' => 'd' ] )
            ->setViewModel('front.profile.profile_company_register')
            ->setAction('companyRegister_1')
            ->render();
    }
    public function companyRegisterSubmit_1(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['a' => 'd' ] )
            ->setViewModel('front.profile.profile_company_register')
            ->setAction('companyRegisterSubmit_1')
            ->render();
    }


    public function companyRegister_2(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['a' => 'd' ] )
            ->setViewModel('front.profile.profile_company_register')
            ->setAction('companyRegister_2')
            ->render();
    }
    public function companyRegisterSubmit_2(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['a' => 'd' ] )
            ->setViewModel('front.profile.profile_company_register')
            ->setAction('companyRegisterSubmit_2')
            ->render();
    }

    public function tickets(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('tickets')
            ->render();
    }

    public function createTicket(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('createTicket')
            ->render();
    }
    public function storeTicket(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.profile.profile')
            ->setAction('storeTicket')
            ->render();
    }
    public function ticketShow($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['ticket_id' => $model_id ] )
            ->setViewModel('front.profile.profile')
            ->setAction('ticketShow')
            ->render();
    }
    public function clientTicketStore($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest($request , ['ticket_id' => $model_id ])
            ->setViewModel('admin.tickets.storeTicketAnswer')
            ->setAction('clientTicketStore')
            ->render();
    }
}
