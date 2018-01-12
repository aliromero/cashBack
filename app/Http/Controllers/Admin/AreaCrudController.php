<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AreaRequest as StoreRequest;
use App\Http\Requests\AreaRequest as UpdateRequest;

class AreaCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Area');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/area');
        $this->crud->setEntityNameStrings('محله', 'محله ها');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->addField([
            'name' => 'name',
            'label' => 'نام محله',
            'type' => 'text',
            'placeholder' => 'مثال : تهرانپارس',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'area_num',
            'label' => 'شماره منطقه',
            'type' => 'number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        $this->crud->addField([
            'name' => 'city_id',
            'label' => 'نام شهر',
            'type' => 'select2',
            'entity' => 'city', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\City" // foreign key model
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'محله',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'area_num',
            'label' => 'منطقه',
            'type' => 'text'
        ]);


        $this->crud->addColumn([
            // 1-n relationship
            'label' => "شهر", // Table column heading
            'type' => "select",
            'name' => 'city_id', // the column that contains the ID of that connected entity;
            'entity' => 'city', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\City", // foreign key model
        ]);



        $cities = City::all();




        foreach ($cities as $city)
        {
            $my_city[$city['id']] =  $city['name'];
        }


        $i=0;
        while ($i<=22){
            $i++;
            $numbers[$i] = $i;
        }



        $this->crud->addFilter([ // simple filter
            'type' => 'dropdown',
            'name' => 'city_id',
            'label'=> 'شهر'
        ],$my_city, function($value) { // if the filter is active
            $this->crud->addClause('where', 'city_id', $value);
        });


        $this->crud->addFilter([ // simple filter
            'type' => 'dropdown',
            'name' => 'area_num',
            'label'=> 'منطقه'
        ],$numbers, function($value) { // if the filter is active
            $this->crud->addClause('where', 'area_num', $value);
        });


         $this->crud->enableAjaxTable();


    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
