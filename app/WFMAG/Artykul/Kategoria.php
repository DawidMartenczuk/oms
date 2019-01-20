<?php

namespace App\_3rd\WFMAG\Artykul;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s category object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Kategoria extends Model
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
    protected $table = 'KATEGORIA_ARTYKULU';

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
    protected $primaryKey = 'ID_KATEGORII';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the articles that belongs to.
     *
     * @return array
     */
    public function artykuly()
    {
        return $this->hasMany('App\_3rd\WFMAG\Artykul', 'ID_KATEGORII');
    }
}
