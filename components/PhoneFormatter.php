<?php


namespace app\components;

use yii\base\Component;
use yii\helpers\Html;

class PhoneFormatter extends Component{ // объявляем класс
    public $number;

    private $defaultPhoneCode = 'RU';

    public function asPhone($number, $code = 'RU', array $options = [])
    {
        if ($number == null) {
            return $this->nullDisplay;
        } else {
            return $this->formatPhone($number, $code, $options);
        }
    }
    /**
     * Функция форматирования
     *
     * @param $number
     * @param string $code
     * @param bool $link
     * @param array $options
     *
     * @return string
     */
    private function formatPhone($number, $code, $options)
    {
        $number = preg_replace("/[^0-9]/", "", $number);
        if (strlen($number) == 6) {
            $number = preg_replace("/([0-9]{3})([0-9]{3})/", "$1-$2", $number);
        } else if (strlen($number) == 7) {
            $number = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $number);
        } else if (strlen($number) == 10) {
            $number = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})/", "($1) $2-$3-$4", $number);
        } else if (strlen($number) == 12) {
            $number = preg_replace("/([0-9]{3})([0-9]{2})([0-9]{2})([0-9]{2})/", "$1 ($2) $3-$4-$5", $number);
        }
        $number = $this->getCodeCountryByIso($code) . ' ' . $number;
        return $number;
    }
    /**
     * Получаем код страны телефона, по умолчанию  RU => +7
     * Реализована только россия
     *
     * @param $code
     *
     * @return null|string
     */
    private function getCodeCountryByIso($code)
    {
        if ($code == null) {
            $code = $this->defaultPhoneCode;
        }
        if ($code == 'RU') {
            return '+7';
        }
        return null;
    }

}