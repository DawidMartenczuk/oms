<?php

namespace App\WFMAG\Zamowienie;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s order delivery object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Dostawa extends Model
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
    protected $table = 'DOSTAWA';

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
    protected $primaryKey = 'ID_DOSTAWY';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the order of the delivery.
     *
     * @return \\App\\WFMAG\\Zamowienie
     */
    public function zamowienie()
    {
        return $this->belongsTo('App\WFMAG\Zamowienie', 'ID_ZAMOWIENIA');
    }

    /**
     * Get the delivery place of the delivery.
     *
     * @return \\App\\WFMAG\\MiejsceDostawy
     */
    public function miejsce()
    {
        return $this->belongsTo('App\WFMAG\Kontrahent\MiejsceDostawy', 'ID_MIEJSCA_DOSTAWY');
    }

    /**
     * Get the form of the delivery.
     *
     * @return \\App\\WFMAG\\FormaDostawy
     */
    public function forma()
    {
        return $this->belongsTo('App\WFMAG\FormaDostawy', 'ID_FORMY_DOSTAWY');
    }
}
