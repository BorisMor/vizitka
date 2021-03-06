<?php

namespace app\helper;

class Str{

    /**
     * транслитерация
     *
     * @param $str
     * @return mixed
     */
    public static function transliteration($str)
    {
        // ГОСТ 7.79B
        $transliteration = array(
            'А' => 'A',
            'а' => 'a',
            'Б' => 'B',
            'б' => 'b',
            'В' => 'V',
            'в' => 'v',
            'Г' => 'G',
            'г' => 'g',
            'Д' => 'D',
            'д' => 'd',
            'Е' => 'E',
            'е' => 'e',
            'Ё' => 'Yo',
            'ё' => 'yo',
            'Ж' => 'Zh',
            'ж' => 'zh',
            'З' => 'Z',
            'з' => 'z',
            'И' => 'I',
            'и' => 'i',
            'Й' => 'J',
            'й' => 'j',
            'К' => 'K',
            'к' => 'k',
            'Л' => 'L',
            'л' => 'l',
            'М' => 'M',
            'м' => 'm',
            'Н' => "N",
            'н' => 'n',
            'О' => 'O',
            'о' => 'o',
            'П' => 'P',
            'п' => 'p',
            'Р' => 'R',
            'р' => 'r',
            'С' => 'S',
            'с' => 's',
            'Т' => 'T',
            'т' => 't',
            'У' => 'U',
            'у' => 'u',
            'Ф' => 'F',
            'ф' => 'f',
            'Х' => 'H',
            'х' => 'h',
            'Ц' => 'Cz',
            'ц' => 'cz',
            'Ч' => 'Ch',
            'ч' => 'ch',
            'Ш' => 'Sh',
            'ш' => 'sh',
            'Щ' => 'Shh',
            'щ' => 'shh',
            'Ъ' => 'ʺ',
            'ъ' => 'ʺ',
            'Ы' => 'Y`',
            'ы' => 'y`',
            'Ь' => '',
            'ь' => '',
            'Э' => 'E`',
            'э' => 'e`',
            'Ю' => 'Yu',
            'ю' => 'yu',
            'Я' => 'Ya',
            'я' => 'ya',
            '№' => '#',
            'Ӏ' => '‡',
            '’' => '`',
            'ˮ' => '¨',
        );

        $str = strtr($str, $transliteration);
        return $str;
    }

    /**
     * транслитерация для URL
     * @param $str
     * @return mixed
     */
    public static function transliterationUrl($str)
    {
        $str = self::transliteration($str);
        $str = mb_strtolower($str, 'UTF-8');
        $str = preg_replace('/[^0-9a-z\-]/', '_', $str);
        $str = preg_replace('|([-]+)|s', '-', $str);
        $str = trim($str, '-');
        return $str;
    }
}
