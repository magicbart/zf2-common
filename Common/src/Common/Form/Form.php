<?php
namespace Common\Form;

use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class Form extends \Zend\Form\Form implements ServiceManagerAwareInterface, TranslatorAwareInterface
{

    protected $modelTable;
    protected $model;

    protected $access = array('insert' => false, 'update' => false, 'delete' => false, 'edit' => true);
    protected $editUrl;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    protected $identity;

    use TranslatorAwareTrait;

    /**
     * @param ServiceManager $serviceManager
     * @return Form
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->translator = $serviceManager->get('translator');
        $this->identity = $serviceManager->get('Zend\Authentication\AuthenticationService')->getIdentity();

        // Call the init function of the form once the service manager is set
        $this->init();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/form/maj');
        $this->setAttribute('class', 'ajaxForm');

        //----- Ajout du className
        $this->add(
            array(
                'name' => 'className',
                'attributes' => array(
                    'type' => 'hidden',
                    'value' => get_called_class(),
                ),
                'options' => array(
                    'grid' => true
                ),
            )
        );

    }

    /**
     * Permet de gérer les formulaire dynamique, donc les select box dépendent de valeurs du formulaire
     * @param array $params
     */
    public function postInit($params)
    {

    }

    public function getAccess($action)
    {
        return $this->access[$action];
    }

    public function getServiceModelTable()
    {
        return $this->modelTable;
    }

    public function getServiceModel()
    {
        return $this->model;
    }

    public function getEditUrl()
    {
        return $this->editUrl;
    }

    public function getModelTable()
    {
        $model = $this->modelTable;
        return new $model;
    }

    public function getModel()
    {
        $model = $this->model;
        return new $model;
    }

    /**
     * @param string $action
     * @param string $resource
     * @return bool
     */
    public function isAllowed($action, $resource = null)
    {
        if ($resource == null) {
            $resource = $this->resource;
        }
        /** @var \Zend\Permissions\Acl\Acl $acl */
        $acl = $this->serviceManager->get('User\Acl');
        return $acl->isAllowed('userRole', $resource, $action);
    }

    /**
     * Converti les messages d'erreur du form en une string unique avec retour à la ligne html
     * @return string $message
     */
    public function getMessages()
    {
        $formErrors = parent::getMessages();
        $message = '';
        // tableau avec tous les éléments erronés
        foreach ($formErrors as $key => $val) {
            if (strlen($message) > 0) {
                $message .= "\n";
            }
            // tableau pour les X erreurs de l'élément concerné
            $fieldName = $this->get($key)->getLabel();
            $message .= $fieldName . ": " . implode("\n", $val);
        }
        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        parent::setData($data);
        //----- partial validatation
        $keys = array_keys((array)$data);
        $columns = array();
        foreach ($keys as $key) {
            if (($this->has($key)) && ($this->getInputFilter()->has($key))) {
                $columns[] = $key;
            }
        }
        $this->setValidationGroup($columns);
    }

    public function addInsertButton()
    {
        if ($this->getAccess('insert') == true) {
            $this->add(
                array(
                    'name' => 'add',
                    'attributes' => array(
                        'type' => 'submit',
                        'value' => 'add',
                    ),
                    'options' => array(
                        'grid' => true,
                    ),
                )
            );
        }
    }

    public function addUpdateButton()
    {
        if ($this->getAccess('update') == true) {
            $this->add(
                array(
                    'name' => 'save',
                    'attributes' => array(
                        'type' => 'submit',
                        'value' => 'sav',
                    ),
                    'options' => array(
                        'grid' => true,
                    ),
                )
            );
        }
    }


    public function addDeleteButton()
    {
        if ($this->getAccess('delete') == true) {
            $this->add(
                array(
                    'name' => 'delete',
                    'attributes' => array(
                        'type' => 'submit',
                        'value' => 'del',
                    ),
                    'options' => array(
                        'grid' => true,
                    ),
                )
            );
        }
    }
}