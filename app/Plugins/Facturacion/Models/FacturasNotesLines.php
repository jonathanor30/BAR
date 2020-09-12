<?php

namespace Models\FacturasNotesLines;

use Illuminate\Database\Eloquent\Model as CustomModel;

class FacturasNotesLines extends CustomModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "lineasfacturasnotes";
    protected $primaryKey = 'idlinea';
    protected $guarded = ["idlinea", "created_at", "updated_at"];
    public function Invoice()
    {
        return $this->belongsTo(\Models\FacturasNotes\FacturasNotes::class, "note_id", "id");
    }
}
