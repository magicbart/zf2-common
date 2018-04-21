<?php
namespace Common\Tools;

use \ArrayObject;


class Tableau
{


    /**
     * Order an array
     * @param array $array
     * @param array $columns
     * @return array
     */
    public static function order($array, $columns)
    {
        $nb = count($array);
        for ($i=0; $i<=$nb; $i++) {
            $change = false;
            for ($j=0; $j<$nb-2; $j++) {
                $row1 = $array[$j];
                $row2 = $array[$j+1];
                $debug = false;
                foreach ($columns as $column => $order) {
                    if ( (($order == 'ASC') && ($row1->$column < $row2->$column)) || (($order == 'DESC') && ($row1->$column > $row2->$column)) ) {
                        break;
                    } else if ( (($order == 'ASC') && ($row1->$column > $row2->$column)) || (($order == 'DESC') && ($row1->$column < $row2->$column)) ) {
                        $array[$j] = $row2;
                        $array[$j+1] = $row1;
                        $change = true;
                        break;
                    }
                }
            }
            if ($change == false) {
                break;
            }
        }
        return $array;
    }

    
	/**
	 * Shullfe an array
	 * @param array $array
	 * @return array
	 */
	public static function shuffle($array)
	{
		shuffle($array);
		return $array;
	}

	/**
	 * Return a ramdom selection of an array
	 * @param array $array
	 * @param integer $nb
	 * @return array
	 */
	public static function rand($array, $nb = 1)
	{
		if (count($array) == 0) {
			return array();
		} else {
			if (count($array) < $nb) {
				$nb = count($array);
			}
			$tmp = array_rand($array, $nb);
			if (!is_array($tmp)) {
				$tmp = array($tmp);
			}
			$result = array();
			foreach ($tmp as $key => $value) {
				$result[] = $array[$value];
			}
			return $result;
		}
	}


	/**
	* Order an 2D Array (Tri à bulle)
	* @param array $array
	* @param string $column
	* @param string $tri ASC|DESC
	* @return array
	*/
	public static function order2DArray($array, $column, $tri = "ASC")
	{
		$list = $array;
		$nbElts = count($list);
		for ($i=0;$i<$nbElts;++$i) {
			for ($j=0;$j<$nbElts-1;++$j) {
				switch ($tri) {
					case "ASC":
						if ($list[$j][$column] > $list[$j+1][$column]) {
							$tmp = $list[$j];
							$list[$j] = $list[$j+1];
							$list[$j+1] = $tmp;
						}
						break;
					case "DESC":
						if ($list[$j][$column] < $list[$j+1][$column]) {
							$tmp = $list[$j];
							$list[$j] = $list[$j+1];
							$list[$j+1] = $tmp;
						}
						break;
				}

			}
		}
		return $list;
	}




	/**
	 * Explode un tableau en deux dimensions donc chaque sous tableau correspond a la 1ere lettre d'une des colonnes
	 * @param array $array
	 * @param string $column
	 * @return array
	 */
	public static function toAlphabetArray($array, $column)
	{
		$tmp = $array;
		$result = array();
		$alphabet = array(
			'A','B','C','D','E','F','G','H','I','J','K','L','M',
			'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
		);
		$nbEltsInTmp = count($tmp);

		if ($nbEltsInTmp > 0) {

			// => First Letter !!
			for ($i=0; $i<$nbEltsInTmp; ++$i) {
				$firstLetter = strtoupper(substr($tmp[$i][$column], 0, 1));
				if (!in_array($firstLetter, $alphabet)) {
					$firstLetter = '#';
				}
				$tmp[$i]['firstLetter'] = $firstLetter;
			}

			// => Construction du tableau
			$lastLetter = $tmp[0]['firstLetter'];
			$ligne = array();
			$ligne[] = $tmp[0];
			for ($i=1; $i<$nbEltsInTmp; ++$i) {
				$currentLetter = $tmp[$i]['firstLetter'];
				if ($lastLetter == $currentLetter) {
					$ligne[] = $tmp[$i];
				} else {
					$result[$lastLetter] = $ligne;
					$ligne = array();
					$ligne[] = $tmp[$i];
					$lastLetter = $currentLetter;
				}
			}
			$result[$lastLetter] = $ligne;
		}

		return $result;

	}


	 /**
	 * Transform a 2D array to a 3D array
	 * @param array $array
	 * @param string column
	 * @param string key to groupe the data
	 * @param nameListe key of the sub array
	 * @return array
	 */
	public static function to3DArray($array, $column, $key, $nameListe, $type = 'array')
	{
		$result = array();
		$nbElts = count($array);
		for ($i=0;$i<$nbElts;++$i) {
			$lastKey = ($i == 0) ? null : $array[$i-1][$key];
			$curKey = $array[$i][$key];
			$curValue = $array[$i][$column];
			switch ($type) {
				case 'array':
					if ($curValue === null) {
						$result[] = array_merge($array[$i], array($nameListe => array()));
					} else if (($curKey == $lastKey) && ($i > 0)) {
						$result[count($result)-1][$nameListe][] = $array[$i];
					} else {
						$result[] = array_merge($array[$i], array($nameListe => array($array[$i])));
					}
					break;
				case 'ArrayObject':
					if ($curValue === null) {
						$result[] = new ArrayObject(
							array_merge($array[$i]->getArrayCopy(), array($nameListe => array())),
							ArrayObject::ARRAY_AS_PROPS
						);
					} else if (($curKey == $lastKey) && ($i > 0)) {
						$result[count($result)-1]->{$nameListe}[] = $array[$i];
					} else {
						$result[] = new ArrayObject(
							array_merge($array[$i]->getArrayCopy(), array($nameListe => array($array[$i]))),
							ArrayObject::ARRAY_AS_PROPS
						);
					}
					break;

			}


		}
		return $result;
	}




	/**
	 * Transform a 2D array to a simple array
	 * @param array $array
	 * @param string $columnValue
	 * @param string $columnKey
	 * @return array
	 */
	public static function toSimpleArray($array, $columnValue, $columnKey = null)
	{
		$result = array();
		foreach ($array as $row) {
			if ($columnKey === null) {
				$result[] = $row[$columnValue];
			} else {
				$result[$row[$columnKey]] = $row[$columnValue];
			}
		}
		return $result;
	}

	/**
	 *
	 * Change the key of an an array by the value of a column
	 * @param array $array
	 * @param string $column
	 * @return array
	 */
	public static function changeKey($array, $column)
	{
		$result = array();
		foreach ($array as $row) {
			$result[$row[$column]] = $row;
		}
		return $result;
	}



	/**
	 *
	 * Merge two array and conserve keys
	 * @param array $arrayA
	 * @param array $arrayB
	 * @return array
	 */
	public static function merge($arrayA, $arrayB)
	{
		foreach ($arrayB as $key => $value) {
			$arrayA[$key] = $value;
		}
		return $arrayA;
	}










/******************************************************* CHECK *******************************************************/




	/**
	 * Remove all null value of an array
	 * @param array $array
	 * @return array
	 */
	public static function unsetNullValue($array)
	{
		foreach ($array as $key => $value) {
			if ( ($value == null) || ($value == '0') ) {
				unset($array[$key]);
			}
		}
		return $array;
	}

	/**
	 * implode
	 */
	public static function implode($separator, $array, $prefix = '', $suffix = '')
	{
		$tmp = array();
		foreach ($array as $key => $value) {
			$tmp[$key] = $prefix . $value . $suffix;
		}
		return implode($separator, $tmp);
	}


	/**
	 * Tranform an array into an URL
	 * @param $array
	 * @return string
	 */
	public static function toURL($array)
	{
		$sUrl = "";
		foreach ($array as $key => $value) {
			$sUrl .= "&" . $key . "=".$value;
		}
		return $sUrl;
	}


	/**
	 *
	 */
	public static function toString($in)
	{
		$out = array();
		foreach ($in as $key => $value) {
			$out[] = "'" . $value . "'";
		}
		return $out;
	}

}