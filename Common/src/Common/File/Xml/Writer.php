<?php
namespace Common\File\Xml;

class Writer extends XMLWriter
{

    private $_fileName = '';

    /**
     * Constructor.
     * @param string $rootElementName A root element's name of a current xml document
     * @param string $xsltFilePath Path of a XSLT file.
     */
    public function __construct($rootElementName = 'root', $xsltFilePath = '')
    {
        $this->openMemory();
        $this->setIndent(true);
        $this->setIndentString(' ');
        $this->startDocument('1.0', 'UTF-8');

        if ($xsltFilePath) {
            $this->writePi('xml-stylesheet', 'type="text/xsl" href="' . $xsltFilePath . '"');
        }

        $this->startElement($rootElementName);
    }

    /**
     * Set the name of the file
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->_fileName = $fileName;
    }

    /**
     * Set an element with a text to a current xml document.
     * @param string $elementName An element's name
     * @param string $elementText An element's text
     */
    public function setElement($elementName, $elementText)
    {
        $this->startElement($elementName);
        $this->text($elementText);
        $this->endElement();
    }

    /**
     * Construct elements and texts from an array.
     * The array should contain an attribute's name in index part
     * and a attribute's text in value part.
     * @param array $array Contains attributes and texts
     */
    public function fromArray($array)
    {
        if (is_array($array)) {
            foreach ($array as $index => $element) {
                if (is_array($element)) {
                    $this->startElement($index);
                    $this->fromArray(utf8_encode($element));
                    $this->endElement();
                } else {
                    $this->setElement($index, utf8_encode($element));
                }
            }
        }
    }

    /**
     * Return the content of a current xml document.
     * @return string Xml document
     */
    public function getDocument()
    {
        $this->endElement();
        $this->endDocument();
        return $this->outputMemory();
    }

    /**
     * Output the content of a current xml document.
     */
    public function output()
    {
        //header('Content-type: text/xml');
        echo $this->getDocument();
    }

}