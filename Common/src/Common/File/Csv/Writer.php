<?php
namespace Common\File\Csv;

class Writer
{

    private $_fileName = '';
    private $_headers = null;
    private $_data = array();
    private $_document = null;

    /**
     * Constructor.
     */
    public function __construct()
    {

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
     * Set the first line of the Csv File
     * @param array $headers
     */
    private function setHeaders($headers)
    {
        $this->_headers = $headers;
    }


    /**
     * Compatibility with Xml Writer
     */
    public function setElement($null)
    {

    }

    /**
     * Compatibility with Xml Writer
     */
    public function startElement($null)
    {

    }


    /**
     * Compatibility with Xml Writer
     */
    public function endElement()
    {

    }


    /**
     * Construct elements and texts from an array.
     * The array should contain an attribute's name in index part
     * and a attribute's text in value part.
     * @param array $prmArray Contains attributes and texts
     * @return null
     */
    public function fromArray($prmArray)
    {
        if (is_array($prmArray)) {
            if ($this->_headers == null) {
                $this->_headers = array_keys($prmArray);
            }
            $this->_data[] = array_values($prmArray);
        }
    }

    /**
     *
     */
    public function setDocument($input)
    {
        $this->_document = $input;
    }


    /**
     * Return the content of a current csv document.
     * @param null
     * @return string Csv document
     */
    public function getDocument()
    {
        if ($this->_document != null) {
            return $this->_document;
        } else {
            $output = implode(";", $this->_headers) . "\n";
            foreach ($this->_data as $key => $row) {
                $output .= implode(";", $row) . "\n";
            }
            return $output;
        }
    }


    /**
     * Output the content of a current xml document.
     * @access public
     * @param null
     */
    public function output()
    {
        header("Content-Type: application/csv-tab-delimited-table");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-disposition: filename=" . $this->_fileName . "-" . date("Y-m-d") . ".csv");
        header("Pragma: public");
        echo $this->getDocument();
    }

}