<?php
namespace Common\Tools;

class String
{

    /**
     * Returns a string to be put into an URL
     * @param string $chaine
     * @return string
     */
    public static function rewrite($chaine)
    {
        //----- Accents
        $normalizeChars = array(
            'Á' => 'A',
            'À' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Å' => 'A',
            'Ä' => 'A',
            'Æ' => 'AE',
            'Ç' => 'C',
            'É' => 'E',
            'È' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Í' => 'I',
            'Ì' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ð' => 'Eth',
            'Ñ' => 'N',
            'Ó' => 'O',
            'Ò' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ú' => 'U',
            'Ù' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'á' => 'a',
            'à' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'å' => 'a',
            'ä' => 'a',
            'æ' => 'ae',
            'ç' => 'c',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'í' => 'i',
            'ì' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ð' => 'eth',
            'ñ' => 'n',
            'ó' => 'o',
            'ò' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ú' => 'u',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ý' => 'y',
            'ß' => 'ss',
            'þ' => 'thorn',
            'ÿ' => 'y'
        );

        //----- Strip slash + trim
        $chaine = strtr(stripslashes(trim($chaine)), $normalizeChars);

        //----- Les caracteres spéciaux (autres que lettres et chiffres en fait)
        $chaine = preg_replace('#([^a-z0-9]+)#i', '-', $chaine);
        $chaine = trim(strtolower($chaine), '-');
        $chaine = preg_replace('#--+#i', '-', $chaine);
        return $chaine;
    }


    /**
     * Return a substring
     * @param string $string
     * @param int $offset
     */
    public static function subStrIn($string, $offset)
    {
        if ($string == null) {
            return '';
        } else {
            if (strlen($string) < $offset * 2) {
                return $string;
            } else {
                return substr($string, $offset, strlen($string) - $offset - 1);
            }
        }
    }


    /**
     * Return a substring
     * @param string $string
     * @param int $offset
     */
    public static function subStrLeft($string, $offset)
    {
        if ($string == null) {
            return '';
        } else if (strlen($string) < $offset) {
            return $string;
        } else {
            return substr($string, 0, $offset);
        }
    }


    /**
     * Generate a random character string
     * @param integer $length
     * @param string chars
     * @return string
     */
    public static function randStr(
        $length = 8,
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'
    ) {
        //----- Length of character list
        $charsLength = (strlen($chars) - 1);

        //----- Start our string
        $string = $chars{rand(0, $charsLength)};

        //----- Generate random string
        for ($i = 1; $i < $length; $i = strlen($string)) {
            //----- Grab a random character from our list
            $r = $chars{rand(0, $charsLength)};

            //----- Make sure the same two characters don't appear next to each other
            if ($r != $string{$i - 1}) {
                $string .= $r;
            }
        }

        //----- Return the string
        return $string;
    }


    /**
     * Format a date
     * @param unknown_type $formatDate
     * @param unknown_type $timestamp
     */
    public static function formatDate($formatDate, $timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = time();
        }

        $formatDate = preg_replace('#([ABDF-IL-PS-UWYZac-eg-jl-or-uwyz])#', '\\\\$1', $formatDate);
        $formatDate = preg_replace('#%\\\\([adg-jlmsyADF-HMSY%])#', '$1', $formatDate);
        $formatDate = date($formatDate, $timestamp);

        $trans = array(
            'Monday' => _t('Lundi'),
            'Tuesday' => _t('Mardi'),
            'Wednesday' => _t('Mercredi'),
            'Thursday' => _t('Jeudi'),
            'Friday' => _t('Vendredi'),
            'Saturday' => _t('Samedi'),
            'Sunday' => _t('Dimanche'),
            'January' => _t('Janvier'),
            'February' => _t('Fevrier'),
            'March' => _t('Mars'),
            'April' => _t('Avril'),
            'June' => _t('Juin'),
            'July' => _t('Juillet'),
            'August' => _t('Aout'),
            'September' => _t('Septembre'),
            'October' => _t('Octobre'),
            'November' => _t('Novembre'),
            'December' => _t('Decembre'),
            'Mon' => _t('Lun'),
            'Tue' => _t('Mar'),
            'Wed' => _t('Mer'),
            'Thu' => _t('Jeu_(date)'),
            'Fri' => _t('Ven'),
            'Sat' => _t('Sam'),
            'Sun' => _t('Dim'),
            'Feb' => _t('Fev'),
            'Apr' => _t('Avr'),
            'May' => _t('Mai'),
            'Jun' => _t('Juin'),
            'Jul' => _t('Juil'),
            'Aug' => _t('Aou'),
            'Dec' => _t('Dec'),
            'nd' => _t('eme2'),
            'rd' => _t('eme3'),
            'th' => _t('eme4')
        );
        $replaceSuffixe = (date('d', $timestamp) == 21 || date('d', $timestamp) == 31) ? _t('eme1') : _t('er');
        $trans = array_merge($trans, array('st' => $replaceSuffixe));
        $formatDate = strtr($formatDate, $trans);
        return $formatDate;
    }

}