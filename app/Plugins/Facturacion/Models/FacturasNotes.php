<?php

namespace Models\FacturasNotes;

use Illuminate\Database\Eloquent\Model as CustomModel;
use Models\FacturaCliente\FacturaCliente;

class FacturasNotes extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "facturasnotes";
    protected $primaryKey = 'id';

    public function Lines()
    {
        return $this->hasMany(\Models\FacturasNotesLines\FacturasNotesLines::class, "note_id", "id");
    }
    public function Client()
    {
        return $this->hasOne(\Models\Clientes\Clientes::class, "id_cliente", "codcliente");
    }
    public function Invoice()
    {
        return $this->belongsTo(FacturaCliente::class, "idfactura", "idfactura");
    }
    public function PaymentM()
    {
        return $this->hasOne(\Models\Configs\PaymentM\PaymentM::class, "id", "medio_pago");
    }
    public function Prepaids()
    {
        return $this->hasMany(\Models\Ingresos\Ingresos::class, "idfactura", "idfactura")->where(function ($q) {
            $types = array(1, 3);
            foreach ($types as $key => $value) {
                $q->orWhere("fp", $value);
            }
        });
    }
}
