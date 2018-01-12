<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Shop;
use App\Models\Vote;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VoteRequest as StoreRequest;
use App\Http\Requests\VoteRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

class VoteCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Vote');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/vote');
        $this->crud->setEntityNameStrings('نظرسنجی', 'نظرسنجی ها');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->addField([  // Select
            'name' => 'shop_id',
            'label' => 'فروشگاه',
            'type' => 'select_shop',
            'entity' => 'shop', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Shop",// foreign key model

        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'عنوان نظر سنجی',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'question',
            'label' => 'سوال نظر سنجی',
            'type' => 'textarea',
        ]);

        $this->crud->addField([
            'name' => 'a1',
            'label' => 'پاسخ #1',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'a2',
            'label' => 'پاسخ #2',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'a3',
            'label' => 'پاسخ #3',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'a4',
            'label' => 'پاسخ #4',
            'type' => 'text',
        ]);

        $this->crud->addField([
            'name' => 'a5',
            'label' => 'پاسخ #5',
            'type' => 'text',
        ]);



        $this->crud->enableAjaxTable();



        $votes = Vote::
        join('shop_user','shop_user.shop_id' , '=' ,'votes.shop_id')
            ->select('votes.*')
            ->where('shop_user.user_id',Auth::user()->id)
            ->get();

        foreach ($votes as $vote)
        {
            $this->crud->addClause('orWhere', 'shop_id', $vote->shop_id);

        }


        $shops = Shop::rep()->get();


        foreach ($shops as $shop) {
            $my_shop[$shop['id']] = $shop['name'];
        }

        $this->crud->addFilter([ // simple filter
            'type' => 'dropdown',
            'name' => 'shop_id',
            'label' => 'فروشگاه'
        ], $my_shop, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'shop_id', $value);
        });





    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
