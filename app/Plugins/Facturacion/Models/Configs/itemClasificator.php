<?php

namespace Models\Configs\itemClasificator;

use Illuminate\Database\Eloquent\Model as CustomModel;

class itemClasificator extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "item_clasificator";
    protected $primaryKey = 'id';
    protected $guarded = ["id", "created_at", "updated_at"];
}
