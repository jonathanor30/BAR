<?php

namespace Models\Ingresos;

use Illuminate\Database\Eloquent\Model as CustomModel;

class Ingresos extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "ingresos_clientes";
    protected $primaryKey = 'id_ingreso';
    public function Country(){
        return $this->belongsTo(\Models\FacturaCliente\FacturaCliente::class, "idfactura", "idfactura");
    }
}
