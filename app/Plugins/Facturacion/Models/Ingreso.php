<?php

namespace Models\Ingreso;

use Illuminate\Database\Eloquent\Model as CustomModel;

class Ingreso extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "ingresos_clientes";
    protected $primaryKey = 'id_ingreso';
    protected $guarded = ["id_ingreso", "created_at", "updated_at"];
}
