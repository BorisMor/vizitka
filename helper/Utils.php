<?php

namespace app\helper;

class Utils {
    public static $yesNo = [
        0 => 'Нет',
        1 => 'Да'
    ];

    public static function valueActive($value)
    {
        return isset(self::$yesNo[$value]) ? self::$yesNo[$value] : self::$yesNo[0];
    }

    /**
     * Преобразуем строку в DateTime
     * @param string $value
     * @param string $valueEmpty
     * @return bool|\DateTime|null
     * @throws \Exception
     */
    public static function isDate($value = '', $valueEmpty = 'now'){
        $value = trim($value);

        if(empty($value)) {
            return empty($valueEmpty) ? null : new \DateTime($valueEmpty);
        }

        $result = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        if ($result == false) {
            $result = \DateTime::createFromFormat('Y-m-d\TH:i:sP', $value);
        }

        if ($result == false) {
            $result = \DateTime::createFromFormat('Y-m-d H:i:s.u', $value);
        }

        if ($result == false) {
            $result = \DateTime::createFromFormat('Y-m-d', $value);
            if ($result !== false) {
                $result->setTime(0, 0, 0);
            }
        }

        if ($result == false) {
            $result = \DateTime::createFromFormat('d-m-Y', $value);
            if ($result !== false) {
                $result->setTime(0, 0, 0);
            }
        }

        if ($result == false) {
            $result = \DateTime::createFromFormat('d.m.Y H:i:s', $value);
        }

        if ($result == false) {
            $result = \DateTime::createFromFormat('d.m.Y', $value);
            if ($result !== false) {
                $result->setTime(0, 0, 0);
            }
        }

        if ($result == false) {
            $result = \DateTime::createFromFormat('d M Y', $value);
            if ($result !== false) {
                $result->setTime(0, 0, 0);
            }
        }


        if($result == false){
            throw new \Exception('Не смогли преобразовать в дату: ' . $value);
        }

        return $result;
    }
}
