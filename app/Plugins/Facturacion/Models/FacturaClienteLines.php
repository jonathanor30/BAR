<?php

namespace Models\FacturaClienteLines;

use Illuminate\Database\Eloquent\Model as CustomModel;

class FacturaClienteLines extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "lineasfacturascli";
    protected $primaryKey = 'idfactura';
    protected $guarded = ["idlinea", "created_at", "updated_at"];
    public function Invoice()
    {
        return $this->belongsTo(\Models\FacturaCliente\FacturaCliente::class, "idfactura", "idfactura");
    }
}
