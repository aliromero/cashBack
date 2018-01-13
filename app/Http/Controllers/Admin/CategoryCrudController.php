<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Request;
use App\Models\Shop;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CategoryRequest as StoreRequest;
use App\Http\Requests\CategoryRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CategoryCrudController extends CrudController
{
    public function setup()
    {


        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Category');

        $this->crud->setRoute(config('backpack.base.route_prefix') . '/category');
        $this->crud->setEntityNameStrings('دسته بندی محصولات', 'دسته بندی های محصولات');
//        $this->crud->setCustomData([Input::get('shop_id')]);
//        $this->crud->setListView('vendor.backpack.crud.category_list');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */


        $this->crud->addField([
            'name' => 'name',
            'label' => 'نام دسته',
            'type' => 'text',
            'placeholder' => 'مثال : لبنیات'
        ]);


        $this->crud->addField([
            'name' => 'shop_id',
            'label' => 'فروشگاه',
            'type' => 'select_shop',
            'model' => Shop::class,
            'attribute' => 'name'

        ]);


        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'نام',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'shop_id',
            'label' => 'فروشگاه',
            'type' => 'select',
            'entity' => 'shop', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Shop"// foreign key model
        ]);


        $shops = Auth::user()->shops;
        $this->crud->query = $this->crud->query->join('shops','shops.id','categories.shop_id')->join('shop_user','shop_user.shop_id','shops.id')->where('shop_user.user_id',Auth::user()->id)->select('categories.*');
        $this->crud->addFilter([ // simple filter
            'type' => 'dropdown',
            'name' => 'shop_id',
            'label' => 'فروشگاه'
        ], function () use ($shops) {
            return $shops->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'categories.shop_id', $value);
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
