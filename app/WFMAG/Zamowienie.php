<?php

namespace App\WFMAG;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * WFMAG`s order object
 *
 * @package     oms
 * @author      <a href="mailto:dawidmartenczuk@naver.com">Dawid Martenczuk</a>
 * @version     1.0.0
 * @copyright   2019 Dawid Martenczuk
 */
class Zamowienie extends Model
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
     * Get the products for the order.
     *
     * @return array
     */
    public function pozycje()
    {
        return $this->hasMany('App\WFMAG\Zamowienie\Pozycja', 'ID_ZAMOWIENIA');
    }

    /**
     * Creates a order in database
     * 
     * @param array data of order
     * 
     * @return Zamowienie
     */
    public static function create($data) {
        $result = [];

        if(!array_key_exists('kontrahent', $data) || !array_key_exists('kontakt', $data) || !array_key_exists('adres', $data) || !array_key_exists('miejsce', $data) || !array_key_exists('invoicing', $data) || !array_key_exists('delivery', $data) || !array_key_exists('payment', $data) || !array_key_exists('articles', $data) || !is_array($data['articles']) || !count($data['articles'])) {
            return NULL;
        }

        $idFirmy = /*Settings::get(static::$configuration['namespace'].'.firma')*/ 1;
        $idMagazynu = /*Settings::get(static::$configuration['namespace'].'.magazyn')*/1;
        $idUzytkownika = /*Settings::get(static::$configuration['namespace'].'.uzytkownik')*/3000001;
        $idTypu = /*Settings::get(static::$configuration['namespace'].'.typ')*/12;
        $kontrahent = $data['kontrahent'];

        $typ = /*Settings::get(static::$configuration['namespace'].'.typWprowadzania')*/1;
        $trybRejestracji = 0;
        $bruttoNetto = 'Netto';
        $flagaStanu = /*Settings::get(static::$configuration['namespace'].'.stan')*/1;

        $idKontrahenta = is_object($data['kontrahent']) ? $data['kontrahent']->ID_KONTRAHENTA : $data['kontrahent'];
        $idKontaktu = is_object($data['kontakt']) ? $data['kontakt']->ID_KONTAKTU : $data['kontakt'];
        $idFormyPlatnosci = is_object($data['payment']) ? $data['payment']->ID_FORMY : $data['payment'];
        $fakturowanie = $data['invoicing'];
        $numer = '<auto> ';

        $statementQuery = [];
        $statementParams = [];

        $statementQuery[] = 
            '
            SET NOCOUNT ON 
            DECLARE @idFirmy Int;
            DECLARE @idKontrahenta Int;
            DECLARE @idMagazynu Int;
            DECLARE @sumaNetto numeric(16,4);
            DECLARE @sumaBrutto numeric(16,4);
            DECLARE @sumaNettoWal numeric(16,4);
            DECLARE @sumaBruttoWal numeric(16,4);
            DECLARE @typ Int;
            DECLARE @data real;
            DECLARE @idUzytkownika Int;
            DECLARE @trybRejestracji Int;
            DECLARE @bruttoNetto char(6);
            DECLARE @flagaStanu Int;
            DECLARE @idZamowienia Int;
            DECLARE @dokument Int;
            DECLARE @idTypu Int;
            DECLARE @formatNumeracji varchar(50);
            DECLARE @okresNumeracji Tinyint;
            DECLARE @Parametr1 Tinyint;
            DECLARE @Parametr2 Tinyint;
            DECLARE @idPracownika Int;
            DECLARE @numer varchar;
            DECLARE @autonumer Int;
            DECLARE @zaliczka Decimal(14,4);
            DECLARE @priorytet Tinyint;
            DECLARE @autoRezerwacja Tinyint;
            DECLARE @nrZamowieniaKlienta Varchar(30);
            DECLARE @przelicznikWalutowy Decimal(16,4);
            DECLARE @symbolWaluty Varchar(3);
            DECLARE @dokumentWalutowy Tinyint;
            DECLARE @rabatNarzut Decimal(6,2);
            DECLARE @znakRabatu Tinyint;
            DECLARE @uwagi Varchar(1000);
            DECLARE @informacjeDodatkowe Varchar(1000);
            DECLARE @osobaZamawiajaca Varchar(101);
            DECLARE @idKontaktu Numeric;
            DECLARE @formaPlatnosci Varchar(50);
            DECLARE @dniPlatnosci Int;
            DECLARE @fakturaParagon Tinyint;
            DECLARE @numerPrzesylki Varchar(50);
            DECLARE @idOperatoraPrzesylki Numeric;
            SET @idFirmy = ?;
            SET @idKontrahenta = ?;
            SET @idMagazynu = ?;
            SET @idUzytkownika = ?;
            SET @typ = ?;
            SET @data = round(cast(getdate() as real),0,1)+36163;
            SET @trybRejestracji = ?;
            SET @bruttoNetto = ?;
            SET @flagaStanu = ?;
            SET @dokument = 2;
            SET @idTypu = ?;
            SET @idPracownika = ?;
            SET @numer = ?;
            SET @autonumer = 0;
            SET @zaliczka = 0.0;
            SET @priorytet = 1;
            SET @autoRezerwacja = 1;
            SET @nrZamowieniaKlienta = ?;
            SET @przelicznikWalutowy = 1;
            SET @symbolWaluty = \'\';
            SET @dokumentWalutowy = 0;
            SET @rabatNarzut = 0;
            SET @znakRabatu = 1;
            SET @uwagi = ?;
            SET @informacjeDodatkowe = \'\';
            SET @osobaZamawiajaca = \'\';
            SET @idKontaktu = ?;
            SET @formaPlatnosci = ?;
            SET @dniPlatnosci = 5;
            SET @fakturaParagon = ?;
            SET @numerPrzesylki = \'\';
            SET @idOperatoraPrzesylki = 0;

            exec RM_DodajZamowienie_Server @idFirmy, @idKontrahenta, @idMagazynu, @typ, @data, @idUzytkownika, 10, @bruttoNetto, @flagaStanu, @idZamowienia OUTPUT;';

        $adres = is_object($data['adres']) ? $data['adres'] : \App\WFMAG\Kontrahent\Adres::findOrFail($data['adres']);
        if($adres->kontrahent->ID_KONTRAHENTA != $kontrahent->ID_KONTRAHENTA) {
            return NULL;
        }
        $miejsce = is_object($data['miejsce']) ? $data['miejsce'] : \App\WFMAG\Kontrahent\MiejsceDostawy::findOrFail($data['miejsce']);
        if($miejsce->kontrahent->ID_KONTRAHENTA != $kontrahent->ID_KONTRAHENTA) {
            return NULL;
        }
                    
        $statementParams = [
            [$idFirmy, \PDO::PARAM_INT],
            [$idKontrahenta, \PDO::PARAM_INT],
            [$idMagazynu, \PDO::PARAM_INT],
            [$idUzytkownika, \PDO::PARAM_INT],
            [$typ, \PDO::PARAM_INT],
            [$trybRejestracji, \PDO::PARAM_INT],
            [$bruttoNetto],
            [$flagaStanu, \PDO::PARAM_INT],
            [$idTypu, \PDO::PARAM_INT],
            [$idUzytkownika, \PDO::PARAM_INT],
            [$numer],
            ['', \PDO::PARAM_STR],
            [
                sprintf('Dane rozliczeniowe: %s'.PHP_EOL.'%s'.PHP_EOL.'%s'.PHP_EOL.'%s %s'.PHP_EOL.PHP_EOL.'Adres dostawy: %s'.PHP_EOL.'%s'.PHP_EOL.'%s'.PHP_EOL.'%s %s'.PHP_EOL.'%s',
                    $adres->NAZWA_CALA,$adres->NIP,$adres->ULICA_LOKAL,$adres->KOD_POCZTOWY,$adres->MIEJSCOWOSC,
                    $miejsce->FIRMA,$miejsce->ODBIORCA,$miejsce->ULICA_LOKAL,$miejsce->KOD_POCZTOWY,$miejsce->MIEJSCOWOSC,$miejsce->TELEFON
                ),
            \PDO::PARAM_STR],
            [$idKontaktu, \PDO::PARAM_INT],
            [$idFormyPlatnosci, \PDO::PARAM_STR],
            [$fakturowanie, \PDO::PARAM_INT]
        ];

        foreach($data['articles'] as $idArtykulu=>$amount) {
            $artykul = \App\WFMAG\Artykul::findOrFail($idArtykulu);
            if($amount > 0) {
                $statementQuery[] = 'exec RM_DodajPozycjeZamowienia_Server
                    ?,
                    @idZamowienia,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?;';
                $statementParams = array_merge($statementParams, [
                    [0, \PDO::PARAM_INT],
                    [intval($idArtykulu), \PDO::PARAM_INT],
                    ['23', \PDO::PARAM_STR],
                    [(string)$amount, \PDO::PARAM_STR],
                    [(string)0, \PDO::PARAM_STR],
                    [(string)0, \PDO::PARAM_STR],
                    [(string)0, \PDO::PARAM_STR],
                    [$artykul->cenaDetaliczna()->first()->CENA_NETTO, \PDO::PARAM_STR],
                    [$artykul->cenaDetaliczna()->first()->CENA_BRUTTO, \PDO::PARAM_STR],
                    [(string)0, \PDO::PARAM_STR],
                    [(string)0, \PDO::PARAM_STR],
                    [(string)1, \PDO::PARAM_STR],
                    [$artykul->jednostka->SKROT, \PDO::PARAM_STR],
                    [(string)0, \PDO::PARAM_STR],
                    ['', \PDO::PARAM_STR],
                    [0, \PDO::PARAM_STR],
                    [10, \PDO::PARAM_STR],
                    [0, \PDO::PARAM_INT],
                    [0, \PDO::PARAM_INT],
                    ['m', \PDO::PARAM_STR]
                ]);
            }
        }

        $statementQuery[] = 'exec JL_PobierzFormatNumeracji_Server
                                @idFirmy,
                                @dokument,
                                @idTypu,
                                @idMagazynu,
                                @formatNumeracji OUTPUT,
                                @okresNumeracji OUTPUT,
                                @Parametr1 OUTPUT,
                                @Parametr2 OUTPUT;';
        $statementQuery[] = 'exec RM_SumujZamowienie_Server
                                @idZamowienia,
                                @sumaNetto OUTPUT,
                                @sumaBrutto OUTPUT,
                                @sumaNettoWal OUTPUT,
                                @sumaBruttoWal OUTPUT;';
        $statementQuery[] = 'update ZAMOWIENIE
                                set WARTOSC_BRUTTO = @sumaBrutto,
                                WARTOSC_NETTO = @sumaNetto,
                                WARTOSC_BRUTTO_WAL = @sumaBruttoWal,
                                WARTOSC_NETTO_WAL = @sumaNettoWal
                                WHERE ID_ZAMOWIENIA = @idZamowienia;';

        if($data['miejsce']) {
            $statementQuery[] = "insert into DOSTAWA (ID_MIEJSCA_DOSTAWY, ID_DOK_MAGAZYNOWEGO, ID_ZAMOWIENIA, ID_FORMY_DOSTAWY, ODEBRANO) VALUES (?, ?, @idZamowienia, ?, ?);";
            $statementParams = array_merge($statementParams, [
                [$data['miejsce']->ID_MIEJSCA_DOSTAWY, \PDO::PARAM_INT],
                [0, \PDO::PARAM_INT],
                [$data['delivery']->ID_FORMY_DOSTAWY, \PDO::PARAM_INT],
                [0, \PDO::PARAM_INT],
            ]);
        }
        
        $statementQuery[] = 'exec RM_ZatwierdzZamowienie_Server
                                @idZamowienia,
                                @idKontrahenta,
                                @idTypu,
                                @numer,
                                @formatNumeracji,
                                @okresNumeracji,
                                @Parametr1,
                                @Parametr2,
                                @autonumer,
                                @idFirmy,
                                @idMagazynu,
                                @data,
                                @data,
                                @zaliczka,
                                @priorytet,
                                @autoRezerwacja,
                                @nrZamowieniaKlienta,
                                @typ,
                                @idPracownika,
                                @przelicznikWalutowy,
                                @data,
                                @symbolWaluty,
                                @dokumentWalutowy,
                                @flagaStanu,
                                @trybRejestracji,
                                @rabatNarzut,
                                @znakRabatu,
                                @uwagi,
                                @informacjeDodatkowe,
                                @osobaZamawiajaca,
                                @idKontaktu,
                                @formaPlatnosci,
                                @dniPlatnosci,
                                @fakturaParagon,
                                @numerPrzesylki,
                                @idOperatoraPrzesylki;';


        $db = DB::connection('wfmag')->getPdo();
        $statement = $db->prepare("
            BEGIN TRANSACTION;
                BEGIN TRY
                    ".implode(PHP_EOL, $statementQuery)."
                END TRY
                BEGIN CATCH
                    SELECT 
                        ERROR_NUMBER() AS ErrorNumber
                        ,ERROR_SEVERITY() AS ErrorSeverity
                        ,ERROR_STATE() AS ErrorState
                        ,ERROR_PROCEDURE() AS ErrorProcedure
                        ,ERROR_LINE() AS ErrorLine
                        ,ERROR_MESSAGE() AS ErrorMessage;

                    IF @@TRANCOUNT > 0
                        ROLLBACK TRANSACTION;
                END CATCH;

                IF @@TRANCOUNT > 0
                    SELECT @idZamowienia AS id
                    COMMIT TRANSACTION;
        ");

        foreach($statementParams as $k=>$v) {
            if(array_key_exists(1, $v)) {
                $statement->bindParam($k+1, $v[0], $v[1]);
            }
            else {
                $statement->bindParam($k+1, $v[0]);
            }
        }
        
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
