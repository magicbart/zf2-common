<?php
namespace Common\View\Helper;

use Zend\View\Helper\HeadLink as ParentHeadLink;

class HeadLink extends ParentHeadLink
{
    /**
     * @inheritdoc
     */
    public function __call($method, $args)
    {
        if (preg_match('/^(?P<action>set|(ap|pre)pend|offsetSet)(?P<type>Canonical|Sitemap)$/', $method, $matches)) {
            $argc = count($args);
            $action = $matches['action'];
            $type = $matches['type'];
            $index = null;

            if ('offsetSet' == $action) {
                if (0 < $argc) {
                    $index = array_shift($args);
                    --$argc;
                }
            }

            if (1 > $argc) {
                throw new \BadMethodCallException(sprintf(
                    '%s requires at least one argument',
                    $method
                ));
            }

            if (is_array($args[0])) {
                $item = $this->createData($args[0]);
            } else {
                $dataMethod = 'createData' . $type;
                $item = $this->$dataMethod($args);
            }

            if ($item) {
                if ('offsetSet' == $action) {
                    $this->offsetSet($index, $item);
                } else {
                    $this->$action($item);
                }
            }

            return $this;
        }

        return parent::__call($method, $args);
    }


    /**
     * Create item for alternate link item
     *
     * @param  array $args
     * @throws \InvalidArgumentException
     * @return stdClass
     */
    public function createDataCanonical(array $args)
    {
        if (1 > count($args)) {
            throw new \InvalidArgumentException(sprintf(
                'Canonical tags require 1 argument; %s provided',
                count($args)
            ));
        }

        $rel = 'canonical';
        $href = array_shift($args);

        $href = (string)$href;

        $attributes = compact('rel', 'href');

        return $this->createData($attributes);
    }


    /**
     * Create item for alternate link item
     *
     * @param  array $args
     * @throws \InvalidArgumentException
     * @return stdClass
     */
    public function createDataSitemap(array $args)
    {
        if (1 > count($args)) {
            throw new \InvalidArgumentException(sprintf(
                'Canonical tags require 1 argument; %s provided',
                count($args)
            ));
        }

        $rel = 'sitemap';
        $href = array_shift($args);

        $href = (string)$href;

        $attributes = compact('rel', 'href');

        return $this->createData($attributes);
    }
}
