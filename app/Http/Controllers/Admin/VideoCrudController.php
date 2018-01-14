<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Models\Video;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VideoRequest as StoreRequest;
use App\Http\Requests\VideoRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

class VideoCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Video');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/video');
        $this->crud->setEntityNameStrings('کلیپ', 'کلیپ های تبلیغاتی');

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
                'name' => 'src',
                'label' => 'انتخاب ویدئو',
                'type' => 'upload',
                'upload' => true,
                'disk' => 'uploads' // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
            ]);



        $shops = Auth::user()->shops;
        $this->crud->query = $this->crud->query->join('shops','shops.id','videos.shop_id')->join('shop_user','shop_user.shop_id','shops.id')->where('shop_user.user_id',Auth::user()->id)->select('videos.*');
        $this->crud->addFilter([ // simple filter
            'type' => 'dropdown',
            'name' => 'shop_id',
            'label' => 'فروشگاه'
        ], function () use ($shops) {
            return $shops->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'videos.shop_id', $value);
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
