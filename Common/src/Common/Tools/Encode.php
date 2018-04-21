<?php
namespace Common\Tools;

class Encode
{

    /**
     * Combinaison de wrap et implode.
     * Retourne une chaine composé de chaque élément du tableau.
     * Chaque élément est séparé par un délimiteur et entouré d'un prefixe et suffixe.
     *
     * @param $glue délimiteur
     * @param $before prefixe
     * @param $after suffixe
     * @param $array tableau
     * @return string
     */
    public static function wrapImplode($glue, $before, $after, $array)
    {
        $output = '';
        foreach ($array as $item) {
            if (!is_string($item)) {
                continue;
            }
            $output .= $before . $item . $after . $glue;
        }
        if (!empty($glue)) {
            return substr($output, 0, -strlen($glue));
        }
        return $output;
    }
}