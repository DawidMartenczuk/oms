<?php

namespace App\WFMAG\Kontrahent;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s delivery address object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class MiejsceDostawy extends Model
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
    protected $table = 'MIEJSCE_DOSTAWY';

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
    protected $primaryKey = 'ID_MIEJSCA_DOSTAWY';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the kontrahent of the delivery address.
     *
     * @return \\App\\WFMAG\\Kontrahent
     */
    public function kontrahent()
    {
        return $this->belongsTo('App\WFMAG\Kontrahent', 'ID_KONTRAHENTA');
    }

    /**
     * Get the country of the delivery address.
     *
     * @return \\App\\WFMAG\\Kraj
     */
    public function kraj()
    {
        return $this->belongsTo('App\WFMAG\Kraj', 'SYM_KRAJU');
    }
}
