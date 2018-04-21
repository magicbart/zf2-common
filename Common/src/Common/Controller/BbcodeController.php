<?php

namespace Common\Controller;

use Common\Filter\Bbcode as BbcodeFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


class BbcodeController extends AbstractActionController
{
    public function __construct()
    {
        // do some stuff!
    }

    public function indexAction()
    {

    }

    public function previewAction()
    {
        $filter = new BbcodeFilter();

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        $post = $request->getPost();
        $texte = isset($post['texte']) ? $post['texte'] : "[b]ERROR[/b]";

        $result = array();
        $result['showPopup'] = array(
            'popupId' => 'popupPreview',
            'title' => 'Preview',
            'texte' => stripslashes($filter->filter(htmlspecialchars($texte))),
            'options' => array(
                'width' => 600,
                'height' => 300
            )
        );
        return new JsonModel($result);
    }


    public function smileyAction()
    {
        $filter = new BbcodeFilter();

        $listeSmiley = $filter->getSmiley();
        $configSmiley = $filter->getConfig();
        $listeImg = '';
        $i = 0;
        foreach ($listeSmiley as $smiley) {
            if ($i++ == 13) {
                $listeImg .= '<br /><br />';
                $i = 0;
            }
            $listeImg .= sprintf(
                '<span class="pointer img_smiley _spriteForum-f f-smiley f-smiley-%s" title="%s">&nbsp;</span>',
                $smiley,
                $smiley
            );
        }
        $listeImg .= '<br />';

        echo '<div id="popup_smiley" title="Smiley">' . $listeImg . '</div>';
        exit;
    }


}
