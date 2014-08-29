<?php

namespace WBDB\Helpers;
use \Exception as exception;

/**
 * UnitConverter
 *
 * @package    WBDB
 * @author     Doug Raum
 * @copyright  2013
 * @access public
 */
class UnitConverter {
    const IMPERIAL = 0;
    const METRIC = 1;

    private $iV = null;
    private $oV = null;
    private $iU = null;
    private $oU = null;

    private $metricUnits = array(
        "SQM",
        "M",
        "KGS"
    );

    private $imperialUnits = array(
        "SQFT",
        "FT",
        "LBS"
    );

    private $validUnits = array(
        "SQM" => array("SQFT" => "squareMetersToSquareFeet"),
        "SQFT" => array("SQM" => "squareFeetToSquareMeters"),
        "M" => array("FT" => "metersToFeetInches"),
        "FT" => array("M" => "feetInchesToMeters"),
        "KGS" => array("LBS" => "kilogramsToPounds"),
        "LBS" => array("KGS" => "poundsToKilograms")
    );

    /**
     * UnitConverter::start()
     *
     * @return
     */
    public function start() {
        $this->iV = null;
        $this->oV = null;
        $this->iU = null;
        $this->oU = null;

        return $this;
    }

    /**
     * UnitConverter::convert()
     *
     * @param mixed $convertTo
     * @return
     */
    public function convert($convertTo = self::IMPERIAL) {

        if (!$this->iV) {
            return;
        }

        if (!$this->iU) {
            return $this->iV;
        }

        if (in_array($this->iU, $this->metricUnits) && $convertTo == self::METRIC) {
            $this->oU = $this->iU;
            return $this->iV;
        }

        if (in_array($this->iU, $this->imperialUnits) && $convertTo == self::IMPERIAL) {
            $this->oU = $this->iU;
            return $this->iV;
        }

        if (!$this->oU) {
            $this->oU = key($this->validUnits[$this->iU]);
        }

        $convertFunc = $this->validUnits[$this->iU][$this->oU];
        return $this->$convertFunc();
    }

    /**
     * UnitConverter::getResultUnit()
     *
     * @return
     */
    public function getResultUnit() {
        return $this->oU;
    }

    /**
     * UnitConverter::value()
     * Set the input value fluently
     *
     * @param mixed $iV
     * @return
     */
    public function value($iV) {
        $this->iV = $iV;
        return $this;
    }

    /**
     * UnitConverter::from()
     * Set the input unit fluently
     *
     * @param mixed $iU
     * @return
     */
    public function from($iU) {
        if (in_array($iU, array_keys($this->validUnits))) {
            $this->iU = $iU;
        } else {
            return $this;
        }
        return $this;
    }

    /**
     * UnitConverter::to()
     * Set the output unit fluently.  Not entirely neccesary, since I only have a
     * one-to-one mapping right now.
     *
     * @param mixed $oU
     * @return
     */
    public function to($oU) {
        if (in_array($oU, $this->validUnits[$this->iU])) {
            $this->oU = $oU;
        } else {
            return $this;
        }
        return $this;
    }

    /**
     * UnitConverter::feetInchestoMeters()
     * Convert feet"inches' (imperial) to meters
     * Also handles decimal feet
     *
     * @return
     */
    private function feetInchestoMeters() {
        if (strstr($this->iU, '.')) {// Decimal feet
            $f = substr($this->iU, 0, strstr($this->iU, '.'));
            $i = ($this->iU - $f) * 12.0;
        } elseif (strstr($this->iU, "'")) {// 7'2" format
            $f = substr($this->iU, 0, strstr($this->iU, "'"));
            $i = substr($this->iU, strstr($this->iU, "'"));
            if (strstr($i, '"')) {
                $i = substr($i, 0, strstr($i, '"'));
            }
        } else {// Just feet
            $f = $this->iU;
            $i = 0;
        }
        return round(($f * 0.3048) + ($i * 0.0254), 1);
    }

    /**
     * UnitConverter::metersToFeetInches()
     * Convert meters to feet"inches'
     * @return
     */
    private function metersToFeetInches() {
        $m = $this->iV;
        $valInFeet = $m * 3.2808399;
        $valFeet = (int)$valInFeet;
        $valInches = round(($valInFeet - $valFeet) * 12);
        $data = $valFeet . "&prime;" . $valInches . "&Prime;";
        $this->oV = $data;
        return $data;
    }

    /**
     * UnitConverter::squareMeterstoSquareFeet()
     * Convert square meters to square feet
     *
     * @return
     */
    private function squareMeterstoSquareFeet() {
        $this->oV = round($this->iV * 10.764, 1);
        return $this->oV;
    }

    /**
     * UnitConverter::squareFeetToSquareMeters()
     * Convert square feet to square meters
     *
     * @return
     */
    private function squareFeetToSquareMeters() {
        $this->oV = round($this->iV / 10.764, 1);
        return $this->oV;
    }

    /**
     * UnitConverter::poundsToKilograms()
     * Convert pounds to kilograms
     *
     * @return
     */
    private function poundsToKilograms() {
        $this->oV = round($this->iV * 0.45359237, 1);
        return $this->oV;
    }

    /**
     * UnitConverter::kilogramsToPounds()
     * Convert kilograms to pounds
     *
     * @return
     */
    private function kilogramsToPounds() {
        $this->oV = round($this->iV * 2.20462, 1);
        return $this->oV;
    }

}
