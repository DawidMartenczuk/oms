<?php

namespace App\_3rd\WFMAG;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s warehouse object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Magazyn extends Model
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
    protected $table = 'MAGAZYN';

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
    protected $primaryKey = 'ID_MAGAZYNU';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}