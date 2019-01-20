<?php

namespace App\_3rd\WFMAG\Artykul;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s price type object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Cena extends Model
{
    /**
     * The connection associated with the model.
     *
     * @var string
     */
    protected $connection = 'wfmag';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'CENA_ARTYKULU';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The primary key used in table to unique identification of the model.
     *
     * @var string
     */
    protected $primaryKey = 'ID_CENY';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['CENA_NETTO', 'CENA_BRUTTO', 'UWAGI'];

    /**
     * Get the articles price that belongs to.
     *
     * @return \\App\\_3rd\\WFMAG\\Cena
     */
    public function cena()
    {
        return $this->belongsTo('App\_3rd\WFMAG\Cena', 'ID_CENY');
    }
}
