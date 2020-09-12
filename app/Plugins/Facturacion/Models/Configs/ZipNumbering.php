<?php

namespace Models\Configs\ZipNumbering;

use Illuminate\Database\Eloquent\Model as CustomModel;

class ZipNumbering extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "zip_numbering";
    protected $primaryKey = 'id';
    protected $guarded = array('id','created_at','updated_at');
}