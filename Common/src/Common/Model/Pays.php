<?php
namespace Common\Model;

class Pays extends Defaut
{

    public $idPays;
    public $codeIso;
    public $libPays_fr;
    public $libPays_en;

    /**
     * Get group label
     * @param string $lang fr|en
     * @return string
     */
    public function getLabel($lang = 'en')
    {
        return ($lang == 'fr') ? $this->libPays_fr : $this->libPays_en;
    }


}