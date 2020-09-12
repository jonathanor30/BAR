<?php

namespace Models\Configs\PaymentM;

use Illuminate\Database\Eloquent\Model as CustomModel;

class PaymentM extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "payment_methods";
    protected $primaryKey = 'id';

}
