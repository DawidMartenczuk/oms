<?php

namespace App\WFMAG;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s consumer object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Kontrahent extends Model
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
    protected $table = 'KONTRAHENT';

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
    protected $primaryKey = 'ID_KONTRAHENTA';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the kontakts for the kontrahent.
     *
     * @return array
     */
    public function kontakty()
    {
        return $this->hasMany('App\WFMAG\Kontrahent\Kontakt', 'ID_KONTRAHENTA');
    }

    /**
     * Get the miejsca dostawy for the kontrahent.
     *
     * @return array
     */
    public function miejscaDostawy()
    {
        return $this->hasMany('App\WFMAG\Kontrahent\MiejsceDostawy', 'ID_KONTRAHENTA');
    }

    /**
     * Get the adreses for the kontrahent.
     *
     * @return array
     */
    public function adresy()
    {
        return $this->hasMany('App\WFMAG\Kontrahent\Adres', 'ID_KONTRAHENTA');
    }

    /**
     * Get the klasyfikacja of the kontrahent.
     *
     * @return \\App\\WFMAG\\Kontrahent\\Klasyfikacja
     */
    public function klasyfikacja()
    {
        return $this->belongsTo('App\WFMAG\Kontrahent\Klasyfikacja', 'ID_KLASYFIKACJI');
    }

    /**
     * Get the klasyfikacja of the kontrahent.
     *
     * @return \\App\\WFMAG\\Kontrahent\\Grupa
     */
    public function grupa()
    {
        return $this->belongsTo('App\WFMAG\Kontrahent\Grupa', 'ID_GRUPY');
    }

    /**
     * Get the user of the kontrahent.
     *
     * @return \\App\\User
     */
    public function kontrahent()
    {
        return $this->belongsTo('App\User', 'ID_KONTRAHENTA', 'ID_KONTRAHENTA');
    }

    /**
     * Creates a customer in database
     * 
     * @param array data of customer
     * 
     * @return Kontrahent
     */
    public static function create($data) {
        $data['ID_KONTRAHENTA'] = (int)((int)\App\WFMAG\Kontrahent::with('ID_KONTRAHENTA')->max('ID_KONTRAHENTA') + 1);
        return parent::create($data);
    }
}
