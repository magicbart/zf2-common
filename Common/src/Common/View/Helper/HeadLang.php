<?php

namespace Common\View\Helper;

use stdClass;
use Zend\View;
use Zend\View\Exception;
use Zend\View\Helper\Placeholder\Container\AbstractStandalone;

/**
 * Helper for switching language
 *
 * Allows the following method calls:
 * @method appendUrl($lang, $url)
 */
class HeadLang extends AbstractStandalone
{
    /**
     * Registry key for placeholder
     *
     * @var string
     */
    protected $regKey = 'Common_View_Helper_Lang';

    protected $separator = ' / ';

    protected $config;

    protected $langs = array(
        'en' => 'English',
        'fr' => 'Français',
    );


    /**
     * Constructor
     *
     * Set separator to PHP_EOL.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setSeparator(' / ');

    }

    /**
     * Return object
     *
     * Returns Headlang helper object; optionally, allows specifying
     *
     * @param  string       $content    Lang contents
     * @param  string       $placement  Append, prepend, or set
     * @return HeadLang
     */
    public function __invoke($content = null, $placement = 'APPEND')
    {
        $this->config = $this->getView()->getHelperPluginManager()->getServiceLocator()
            ->get('ServiceManager')->get('Appli\Config');

        if ((null !== $content) && is_string($content)) {
            switch (strtoupper($placement)) {
                case 'APPEND':
                default:
                    $action = 'appendUrl';
                    break;
            }
            $this->$action($content);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args)
    {
        if (preg_match('/^(?P<action>set|(ap|pre)pend|offsetSet)(Url)$/', $method, $matches)) {
            $index  = null;
            $argc   = count($args);
            $action = $matches['action'];

            if ('offsetSet' == $action) {
                if (0 < $argc) {
                    $index = array_shift($args);
                    --$argc;
                }
            }

            if (1 > $argc) {
                throw new Exception\BadMethodCallException(sprintf(
                    'Method "%s" requires minimally content for the stylesheet',
                    $method
                ));
            }

            $lang = $args[0];
            $url = $args[1];
            $link = $args[2];

            $item = $this->createData($lang, $url, $link);

            if ('offsetSet' == $action) {
                $this->offsetSet($index, $item);
            } else {
                $this->$action($item);
            }

            return $this;
        }

        return parent::__call($method, $args);
    }

    /**
     * Create string representation of placeholder
     *
     * @param  string|int $indent
     * @return string
     */
    public function toString($indent = null)
    {
        $indent = (null !== $indent)
            ? $this->getWhitespace($indent)
            : $this->getIndent();

        $items = array();
        $this->getContainer()->ksort();
        foreach ($this as $item) {
            $items[] = $this->itemToString($item, $indent);
        }

        $return = $indent . implode($this->getSeparator() . $indent, $items);
        $return = preg_replace("/(\r\n?|\n)/", '$1' . $indent, $return);

        return $return;
    }


    /**
     * Create data item for use in stack
     *
     * @param  string $lang
     * @param  array  $url
     * @return stdClass
     */
    public function createData($lang, $url, $link)
    {
        $data = new stdClass();
        $data->lang = $lang;
        $data->url = $url;
        $data->link = $link;


        return $data;
    }


    /**
     * Convert content and attributes into valid style tag
     *
     * @param  stdClass $item   Item to render
     * @return string
     */
    public function itemToString(stdClass $item)
    {
        if ($item->link == true) {
            $html = sprintf('<a href="%s">%s</a>', $item->url, $this->langs[$item->lang]);
        } else {
            $html = $this->langs[$item->lang];
        }
        return $html;
    }

}
