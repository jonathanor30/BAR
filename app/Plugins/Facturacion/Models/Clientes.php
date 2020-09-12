<?php

namespace Models\Clientes;

use Illuminate\Database\Eloquent\Model as CustomModel;

class Clientes extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "clientes";
    protected $primaryKey = 'id_cliente';
    protected $guarded = ["id_cliente", "created_at", "updated_at"];
    
    public function Country(){
        return $this->hasOne(\Models\Configs\Country\Country::class, "codiso", "pais");
    }
    public function Invoices()
    {
        return $this->hasMany(\Models\FacturaCliente\FacturaCliente::class, "codcliente", "id_cliente");
    }
}
