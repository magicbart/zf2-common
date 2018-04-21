<?php

namespace Common\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


class FormController extends AbstractActionController
{
    public function __construct()
    {
        // do some stuff!
    }

    public function majAction()
    {
        $result = array();

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();

            //$form = $this->serviceLocator->get($request->getPost('className'));
            $formManager = $this->serviceLocator->get('FormElementManager');
            $form = $formManager->get($request->getPost('className'));
            $table = $this->serviceLocator->get($form->getServiceModelTable());
            $model = $this->serviceLocator->get($form->getServiceModel());

            if (($form->isAllowed('insert')) || ($form->isAllowed('update'))) {
                $form->setInputFilter($model->getInputFilter());
                $form->setData($request->getPost());
                if ($form->isValid()) {
                    if (($post['submit'] == 'Add') && ($form->isAllowed('insert'))) {
                        if ($table->insertRow($form->getData())) {
                            $result['message'] = 'Ajout effectué';
                            //----- Update Link
                            $url = $table->getUpdateLink();
                            if ($url) {
                                $result['url'] = $url;
                                $result['id'] = $table->getLastInsertValue();
                            }
                        } else {
                            $result = array('success' => false, 'message' => nl2br($table->getMessages()));
                        }
                    } else {
                        if (($post['submit'] == 'Edit') && ($form->isAllowed('update'))) {
                            if ($table->updateRow($form->getData())) {
                                $result['success'] = true;
                                $result['message'] = 'Mise à jour effectuée';
                            } else {
                                $result = array('success' => false, 'message' => nl2br($table->getMessages()));
                            }
                        } else {
                            $result = array('success' => false, 'message' => 'ERROR FORM');
                        }
                    }

                } else {
                    $result = array('success' => false, 'message' => nl2br($form->getMessages()));
                }
            } else {
                $result = array('success' => false, 'message' => "ACCESS DENIED");
            }
        } else {
            $result = array('success' => false, 'message' => "ERROR FORM");
        }

        return new JsonModel($result);
    }


    /**
     *
     * Enter description here ...
     */
    public function majGridAction()
    {
        $result = array();

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form = $this->serviceLocator->get($request->getPost('className'));
            $table = $this->serviceLocator->get($form->getServiceModelTable());
            $model = $this->serviceLocator->get($form->getServiceModel());

            $post = $request->getPost();

            $form->postInit($post);

            $form->setInputFilter($model->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                switch ($post['gdAction']) {
                    case 'add':
                        if ($form->isAllowed('insert')) {
                            if ($object = $table->insertRow($form->getData())) {
                                $result = array('success' => true, 'message' => 'Mise à jour effectuée');
                                $form->populateValues($object->getArrayCopy());
                                $form->addUpdateButton();
                                $form->addDeleteButton();
                                $sm = $this->getEvent()->getApplication()->getServiceManager();
                                $helper = $sm->get('viewHelperManager')->get('gridForm');
                                $result['newLine'] = $helper->render($form);
                            } else {
                                $result = array('success' => false, 'message' => nl2br($table->getMessages()));
                            }
                        } else {
                            $result = array('success' => false, 'message' => 'ACCESS DENIED');
                        }
                        break;
                    case 'save':
                        if ($form->isAllowed('update')) {
                            if ($table->updateRow($form->getData())) {
                                $result = array('success' => true);
                            } else {
                                $result = array('success' => false, 'message' => nl2br($table->getMessages()));
                            }
                        } else {
                            $result = array('success' => false, 'message' => 'ACCESS DENIED');
                        }
                        break;
                    case 'delete':
                        if ($form->isAllowed('delete')) {
                            if ($table->deleteRow($form->getData())) {
                                $result = array('success' => true);
                            } else {
                                $result = array('success' => false, 'message' => nl2br($table->getMessages()));
                            }
                        } else {
                            $result = array('success' => false, 'message' => 'ACCESS DENIED');
                        }
                        break;
                    default:

                        break;

                }
            } else {
                $result = array('success' => false, 'message' => nl2br($form->getMessages()));
            }

        } else {
            $result = array('success' => false, 'message' => "Erreur de formulaire");
        }

        return new JsonModel($result);
    }


}
