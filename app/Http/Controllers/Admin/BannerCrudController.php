<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\BannerRequest as StoreRequest;
use App\Http\Requests\BannerRequest as UpdateRequest;

class BannerCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Banner');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/banner');
        $this->crud->setEntityNameStrings('بنر فروشگاهی', 'بنرهای فروشگاهی');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->addField([  // Select
            'name' => 'shop_id',
            'label' => 'ارجاع به فروشگاه',
            'type' => 'select_shop',
            'entity' => 'shop', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Shop",// foreign key model
            'attributes' => ['required' => '', 'id' => 'shop'],
        ]);

        $this->crud->addField([
            'name' => 'image',
            'label' => 'تصویر',
            'type' => 'image',
            'upload' => true,
            'disk' => 'uploads',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 6/3, // ommit or set to 0 to allow any aspect ratio
            'prefix' => 'uploads/',
            'hint' => 'بنر تصویری را انتخاب کنید',
        ]);

        $this->crud->addField([
            'name' => 'status',
            'label' => 'وضعیت',
            'type' => 'checkbox',
            'hint' => 'در صورتی که تیک این قسمت را نزنید این بنر به کاربران نمایش داده نمیشود',
        ]);


        $this->crud->addColumn([
            'name' => 'shop_id',
            'label' => 'فروشگاه',
            'type' => 'select',
            'entity' => 'shop', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Shop"// foreign key model
        ]);


        $this->crud->addColumn([
            'name' => 'status',
            'label' => ' وضعیت',
            'type' => 'check',

        ]);


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
