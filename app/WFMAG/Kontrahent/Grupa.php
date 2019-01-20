<?php

namespace App\_3rd\WFMAG\Kontrahent;

use Illuminate\Database\Eloquent\Model;

/**
 * WFMAG`s customer group object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Grupa extends Model
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
    protected $table = 'GRUPA_KONTRAHENTA';

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
    protected $primaryKey = 'ID_GRUPY';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the kontrahenci for the group.
     *
     * @return array
     */
    public function kontrahenci()
    {
        return $this->hasMany('App\_3rd\WFMAG\Kontrahent', 'ID_GRUPY');
    }
}
