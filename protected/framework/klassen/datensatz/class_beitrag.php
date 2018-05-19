<?php

include_once dirname(__FILE__).'/../datenbank/class_drive_entity.php';
/*******************************************************************************************************************//**
 * Repräsentation eines Beitrags.
 *
 * @ingroup grp_recordset
 **********************************************************************************************************************/
class CBeitrag extends CDriveEntity
{
    /*****************************************************************************************************************/    /**
     * @name Tabellenname
     **************************************************************************************************************//*@{*/

    const mcTabName = 'beitraege';

    private $mBezeichnung;
    private $mBeitrag;

    public function __construct($BeitragID = 0)
    {
        parent::__construct(self::mcTabName, $BeitragID);
    }

    public function __toString()
    {
        if (!$this->getBeitragID()) {
            return 'Kein Beitrag';
        }

        return $this->mBezeichnung.': '.$this->mBeitrag;
    }

    public function setInitVals()
    {
        parent::setInitVals();
        $this->mBeitrag = 0.0;
        $this->mBezeichnung = '';
    }

    public static function isValidID($BeitragID)
    {
        return CDriveEntity::genericIsValidID(self::mcTabName, $BeitragID);
    }

    public function load($BeitragID)
    {
        self::setInitVals();
        $this->setBeitragID($BeitragID);
        $format = 'SELECT bezeichnung, beitrag '.
                  'FROM beitraege WHERE beitrag_id=%s';
        $query = sprintf($format, $this->getBeitragID());
        if (!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
            throw new Exception(mysqli_error(CDriveEntity::getDB()));
        }
        $row = mysqli_fetch_row($result);
        if (!$row) {
            throw new Exception('Beitrag mit beitrag_id='.$BeitragID.' nicht gefunden!');
        }
        $this->mBezeichnung = lS($row[0]);
        $this->mBeitrag = lF($row[1]);
    }

    public function save()
    {
        self::check();
        CDriveEntity::evlCheckMsg();
        self::store();
    }

    public function store()
    {
        if (self::isValidID($this->getID())) {
            $format = 'UPDATE beitraege SET '.
                      "bezeichnung=%s, beitrag='%s' ".
                      'WHERE beitrag_id=%s';
            $query = sprintf($format, sS($this->mBezeichnung), sD($this->mBeitrag), $this->getID());
        } else {
            $format = 'INSERT INTO beitraege '.
                      '(bezeichnung, beitrag) '.
                      "VALUES (%s, '%s')";
            $query = sprintf($format, sS($this->mBezeichnung), sD($this->mBeitrag));
        }
        echo $query;
        if (!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
            throw new Exception(mysqli_error(CDriveEntity::getDB()));
        }

        // Basisklasse
        parent::store();
    }

    public function check()
    {
    }

    public function isDeletable()
    {
        /*
         * In welchen Tabellen wird eine beitrag_id eingetragen und wie kritisch ist diese Tabelle?
         *
         * athleten_mitglieder....kritisch
         */

        $Zaehler = 0;

        $query = 'SELECT COUNT(*) FROM athleten_mitglieder WHERE beitrag_id='.$this->getBeitragID();
        if (!$result = mysqli_query(CDriveEntity::getDB(), $query)) {
            throw new Exception(mysqli_error(CDriveEntity::getDB()));
        }
        $row = mysqli_fetch_row($result);
        $Zaehler += (int) $row[0];

        return ($Zaehler) ? (false) : (true);
    }

    final public function getBeitragID()
    {
        return CDriveEntity::getID();
    }

    final public function setBeitragID($BeitragID)
    {
        CDriveEntity::setID($BeitragID);
    }

    final public function getBezeichnung()
    {
        return $this->mBezeichnung;
    }

    final public function setBezeichnung($bezeichnung)
    {
        $this->mBezeichnung = $bezeichnung;
    }

    final public function getBeitrag()
    {
        return number_format($this->mBeitrag, 2, ',', '.');
    }

    final public function setBeitrag($beitrag)
    {
        //throw new Exception('Fix: auf 2 Nachkommastellen!');
        $f = str_replace(',', '.', $beitrag);
        $f = floatval($f);
        $f = str_replace(',', '.', $f);
        $this->mBeitrag = $f;
    }
}
