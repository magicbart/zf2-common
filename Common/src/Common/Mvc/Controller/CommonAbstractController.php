<?php

namespace Common\Mvc\Controller;

use Common\View\Helper\HeadLang;
use Zend\Cache\Storage\StorageInterface;
use Zend\I18n\Translator\Translator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\HeadMeta;
use Zend\View\Helper\HeadScript;
use Zend\View\Helper\HeadTitle;

/**
 * Class CommonAbstractController
 * Allow controller to know available variables.
 */
class CommonAbstractController extends AbstractActionController
{
    /** @var Container $session */
    public $session;
    /** @var StorageInterface $cache */
    public $cache;
    /** @var HeadLang $headLang */
    public $headLang;
    /** @var HeadTitle $headTitle */
    public $headTitle;
    /** @var HeadScript $headScript */
    public $headScript;
    /** @var HeadLink $headLink */
    public $headLink;
    /** @var HeadMeta $headMeta */
    public $headMeta;
    /** @var Translator $translator */
    public $translator;
    /** @var string $lang */
    public $lang;
}