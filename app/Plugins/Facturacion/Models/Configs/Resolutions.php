<?php

namespace Models\Configs\Resolutions;

use Illuminate\Database\Eloquent\Model as CustomModel;

class Resolutions extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "resolutions";
    protected $primaryKey = 'id';
    protected $guarded = ["id", "created_at", "updated_at"];
}
