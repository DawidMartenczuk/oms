<?php

namespace App\WFMAG\Zamowienie;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s order product object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Pozycja extends Model
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
    protected $table = 'ZAMOWIENIE';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key used in table to unique identification of the model.
     *
     * @var string
     */
    protected $primaryKey = 'ID_ZAMOWIENIA';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the order of the order product.
     *
     * @return \\App\\_3rd\\WFMAG\\Kontrahent
     */
    public function zamowienie()
    {
        return $this->belongsTo('App\WFMAG\Zamowienie', 'ID_ZAMOWIENIA');
    }
}
