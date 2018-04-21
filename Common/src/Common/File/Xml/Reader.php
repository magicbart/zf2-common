<?php
namespace Common\File\Xml;

class Reader extends XMLReader
{


    /**
     * Transforme un fichier xml en tableau
     * @return array
     */
    public function toArray()
    {
        $assoc = null;
        $n = 0;
        while ($this->read()) {
            if ($this->nodeType == XMLReader::END_ELEMENT) {
                break;
            }
            if ($this->nodeType == XMLReader::ELEMENT and !$this->isEmptyElement) {
                $assoc[$n]['name'] = $this->name;
                if ($this->hasAttributes) {
                    while ($this->moveToNextAttribute()) {
                        $assoc[$n]['atr'][$this->name] = $this->value;
                    }
                }
                $assoc[$n]['val'] = $this->toArray();
                $n++;
            } else {
                if ($this->isEmptyElement) {
                    $assoc[$n]['name'] = $this->name;
                    if ($this->hasAttributes) {
                        while ($this->moveToNextAttribute()) {
                            $assoc[$n]['atr'][$this->name] = $this->value;
                        }
                    }
                    $assoc[$n]['val'] = "";
                    $n++;
                } else {
                    if ($this->nodeType == XMLReader::TEXT) {
                        $assoc = $this->value;
                    }
                }
            }
        }
        return $assoc;
    }

}