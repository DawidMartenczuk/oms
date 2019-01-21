<?php

namespace App\WFMAG;

use Illuminate\Database\Eloquent\Model;

use Settings;

/**
 * WFMAG`s article object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Artykul extends Model
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
    protected $table = 'ARTYKUL';

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
    protected $primaryKey = 'ID_ARTYKULU';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'STAN'              => 'float',
        'ILOSC_EDYTOWANA'   => 'float',
        'ZAMOWIONO'         => 'float',
        'DO_REZERWACJI'     => 'float',
        'ZAREZERWOWANO'     => 'float',
        'OD_DOSTAWCOW'      => 'float',
        'DO_ODBIORCOW'      => 'float'
    ];

    /**
     * Get the articles magazyn that belongs to.
     *
     * @return \\App\\_3rd\\WFMAG\\Magazyn
     */
    public function magazyn()
    {
        return $this->belongsTo('App\WFMAG\Magazyn', 'ID_MAGAZYNU');
    }

    /**
     * Get the articles prices that belongs to.
     *
     * @return \\App\\_3rd\\WFMAG\\Artykul\\Cena
     */
    public function ceny()
    {
        return $this->hasMany('App\WFMAG\Artykul\Cena', 'ID_ARTYKULU');
    }

    /**
     * Get the articles prices that belongs to.
     *
     * @return \\App\\_3rd\\WFMAG\\Artykul\\Cena
     */
    public function cenaDetaliczna()
    {
        return $this->ceny()->where('ID_CENY', 1);
    }

    /**
     * The magazine documents that belong to the article.
     *
     * @return array
     */
    public function dokumentyMagazynowe()
    {
        return $this->belongsToMany('App\WFMAG\DokumentMagazynowy', 'POZYCJA_DOKUMENTU_MAGAZYNOWEGO', 'ID_ARTYKULU', 'ID_DOK_MAGAZYNOWEGO')->whereNotNull('POZYCJA_DOKUMENTU_MAGAZYNOWEGO.ID_DOK_MAGAZYNOWEGO')->orderBy('DATA', 'DESC');
    }

    /**
     * The magazine documents that belong to the article.
     */
    public function rozchody()
    {
        return $this->dokumentyMagazynowe()->where('RODZAJ_POZYCJI', 'R');
    }

    /**
     * The magazine documents that belong to the article.
     */
    public function przychody()
    {
        return $this->dokumentyMagazynowe()->where('RODZAJ_POZYCJI', 'P');
    }

    /**
     * Count article amount
     *
     * @return double
     */
    public function amount()
    {
        return $this->STAN - $this->ILOSC_EDYTOWANA - $this->ZAREZERWOWANO;
    }

    /**
     * Scope a query to only include available articles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereRaw('(([STAN] - [ILOSC_EDYTOWANA] - [ZAREZERWOWANO]) > 0)');
    }

    /**
     * Scope a query to only include available articles.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDetal($query)
    {
        return $query->whereHas('ceny', function($q) {
            $q->where('ID_CENY', 1)->where('CENA_NETTO', '>', 0);
        });
    }

    /**
     * Scope a query to unique articles by indexes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnique($query)
    {
        return $query->groupBy(['INDEKS_HANDLOWY', 'KOD_KRESKOWY']);
    }
}