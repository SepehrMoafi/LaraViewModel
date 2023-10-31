<?php

namespace Modules\User\Http\Controllers\Admin\Users;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\ViewModels\MasterViewModel;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('admin.user.subscribeUsersViewModel')
            ->setAction('index')
            ->render();
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.newsletterSubscription.NewsletterSubscriptionStore')
            ->setAction('store')
            ->render();
    }
}
