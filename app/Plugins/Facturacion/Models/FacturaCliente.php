<?php

namespace Models\FacturaCliente;

use Illuminate\Database\Eloquent\Model as CustomModel;
use Models\FacturasNotes\FacturasNotes;

class FacturaCliente extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "facturascli";
    protected $primaryKey = 'idfactura';

    public function Lines()
    {
        return $this->hasMany(\Models\FacturaClienteLines\FacturaClienteLines::class, "idfactura", "idfactura");
    }
    public function Client()
    {
        if ($this->codcliente != null) {
            return \Models\Clientes\Clientes::where("id_cliente", $this->codcliente)->get();
        } else {
            return $this->hasOne(\Models\Clientes\Clientes::class, "id_cliente", "codcliente");
        }
    }
    public function Prepaids()
    {
        return $this->hasMany(\Models\Ingresos\Ingresos::class, "idfactura", "idfactura");
    }
    public function PaymentM()
    {
        return $this->hasOne(\Models\Configs\PaymentM\PaymentM::class, "id", "medio_pago");
    }

    public function Notes()
    {
        return $this->hasMany(FacturasNotes::class, "idfactura", "idfactura");
    }
}
