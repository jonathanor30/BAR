<?php

namespace Models\Producto;

use Illuminate\Database\Eloquent\Model as CustomModel;

class Producto extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "producto";
    protected $primaryKey = 'IdProducto';
   
}
