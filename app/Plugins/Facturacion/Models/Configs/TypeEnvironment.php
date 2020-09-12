<?php

namespace Models\Configs\TypeEnvironment;

use Illuminate\Database\Eloquent\Model as CustomModel;

class TypeEnvironment extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "type_environments";
    protected $primaryKey = 'id';

}
