<?php
namespace Common\Form\View\Helper;

use Zend\Form\FormInterface;
use Zend\Form\View\Helper\Form;

class GridForm extends Form
{
    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function render(FormInterface $form)
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $form->setAttribute('action', '/form/maj-grid');

        $formContent = '';
        /** @var FormInterface $element */
        foreach ($form as $element) {
            if ($element->getOption('grid') === true) {
                if ($element->getAttribute('type') != 'hidden') {
                    $element->setAttribute('style', 'width:98%;');
                    $formContent .= '<div class="cell" style="width:' .
                        $element->getOption('width') . 'px">' .
                        $this->getView()->formElement($element) . '</div>';
                } else {
                    $formContent .= $this->getView()->formRow($element);
                }
            }
        }

        //----- Ajout d'un lien d'edition
        if ($form->getAccess('edit')) {
            $formContent .= '<div class="cell" style="width:50px"><a href="' . $form->getEditUrl() . '">Edit</a></div>';
        }

        return $this->openTag($form) . $formContent . $this->closeTag();
    }

}
