<?php
namespace Common\Filter;

use DateTime;
use Zend\Filter\FilterInterface as FilterInterface;

class Date implements FilterInterface
{
    private $formatOutput;
    private $formatInput;


    public function __construct($formatOutput = 'Y-m-d', $formatInput = 'd/m/Y')
    {
        $this->_setFormatOutput($formatOutput);
        $this->_setFormatInput($formatInput);
    }

    private function _setFormatOutput($formatOutput)
    {
        $this->formatOutput = $formatOutput;
    }

    private function _getFormatOutput()
    {
        return $this->formatOutput;
    }

    private function _setFormatInput($formatInput)
    {
        $this->formatInput = $formatInput;
    }

    private function _getFormatInput()
    {
        return $this->formatInput;
    }

    public function filter($input)
    {
        $date = DateTime::createFromFormat(
            $this->getFormatInput(),
            $input
        );
        if ($date) {
            return $date->format($this->getFormatOutput());
        } else {
            return $input;
        }
    }
}
