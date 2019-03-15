<?php

namespace App\WFMAG;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s warehouse document type object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class DokumentMagazynowy extends Model
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
    protected $table = 'DOKUMENT_MAGAZYNOWY';

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
    protected $primaryKey = 'ID_DOK_MAGAZYNOWEGO';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the client of the warehouse document.
     *
     * @return \\App\\WFMAG\\Kontrahent
     */
    public function kontrahent()
    {
        return $this->belongsTo('App\WFMAG\Kontrahent', 'ID_KONTRAHENTA');
    }
}
