<?php

namespace Models\Configs\Company;

use Illuminate\Database\Eloquent\Model as CustomModel;

class Company extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "facturacion_electronica";
    protected $primaryKey = 'idconfig';
    public function Type_E()
    {
        return $this->hasOne(\Models\Configs\TypeEnvironment\TypeEnvironment::class, "id", "tipo_ambiente");
    }

    public function Country()
    {
        return $this->hasOne(\Models\Configs\Country\Country::class, "codiso", "codigo_pais");
    }
}
