<?php
/**
 *
 * Enter description here ...
 * @author BENARD David
 *
 */
namespace Common\Form\View\Helper;

use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\Form\View\Helper\AbstractHelper;

class DataGrid extends AbstractHelper
{

    /**
     * Invoke as function
     *
     * @param  null|FormInterface $form
     * @param
     * @return Form
     */
    public function __invoke(FormInterface $form, $mixed, $initValues = array())
    {
        if (!$form) {
            return $this;
        }

        return $this->render($form, $mixed, $initValues);
    }


    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function render(FormInterface $form, $mixed, $initValues)
    {
        $content = '<div class="dataGrid">';

        //----- header
        $content .= '<div class="header">';
        foreach ($form as $element) {
            if ($element->getOption('grid') === true) {
                if ($element->getAttribute('type') != 'hidden') {
                    $content .= '<div class="cell" style="width:' .
                        $element->getOption('width') . 'px">' .
                        $element->getLabel() . '</div>';
                }
            }
        }
        $content .= '</div>';

        //----- body
        $myForm = clone($form);
        //----- Ajout des boutons
        //$myForm->addEditLink();
        $myForm->addUpdateButton();
        $myForm->addDeleteButton();

        $content .= '<div class="body">';
        foreach ($mixed as $a) {
            $tmpForm = clone($myForm);
            $values = (is_array($a)) ? $a : $a->getArrayCopy();
            $tmpForm->populateValues($values);
            $content .= $this->getView()->gridForm($tmpForm);
        }

        $content .= '</div>';


        //----- footer
        if ($tmpForm->getAccess('insert') == true) {
            $content .= '<div class="footer">';
            $tmpForm = clone($form);
            $tmpForm->addInsertButton();
            $tmpForm->populateValues($initValues);
            $content .= $this->getView()->gridForm($tmpForm);
            $content .= '</div>';
        }

        $content .= '</div>';

        return $content;
    }

}
