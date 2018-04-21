<?php
namespace Common\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\EmailAddress as ValidatorEmailAdress;

class MultiEmail extends AbstractValidator
{
    const VALID = 'float';

    protected $messageTemplates = array(
        self::VALID => "La liste n'est pas valide",
    );

    protected $delimiter = "\n";

    public function isValid($value)
    {
        $this->setValue($value);
        $validator = new ValidatorEmailAdress();

        $bool = true;
        $emails = explode($this->getOption('delimiter'), $value);
        foreach ($emails as $email) {
            if (!$validator->isValid($email)) {
                $this->error(self::VALID);
                return false;
            }
        }

        if ($bool === false) {
            $this->error(self::VALID);
        }
        return true;
    }
}