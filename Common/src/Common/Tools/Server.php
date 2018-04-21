<?php
namespace Common\Tools;

class Server
{

    /**
     * Returns IP of the visitor
     */
    public static function getVisitorIP()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }


    /**
     * Return the previous url
     * @return string
     */
    public static function getPreviousUrl()
    {
        $uri = '';
        $parsed = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;
        if (!is_array($parsed)) {
            return false;
        }
        if (isset($parsed['scheme'])) {
            $uri = $parsed['scheme'] ? $parsed['scheme'] . ':' . ((strtolower(
                        $parsed['scheme']
                    ) == 'mailto') ? '' : '//') : '';
        }
        if (isset($parsed['user'])) {
            $uri .= $parsed['user'] ? $parsed['user'] . ($parsed['pass'] ? ':' . $parsed['pass'] : '') . '@' : '';
        }
        if (isset($parsed['host'])) {
            $uri .= $parsed['host'] ? $parsed['host'] : '';
        }
        if (isset($parsed['port'])) {
            $uri .= $parsed['port'] ? ':' . $parsed['port'] : '';
        }
        if (isset($parsed['path'])) {
            $uri .= $parsed['path'] ? $parsed['path'] : '';
        }
        if (isset($parsed['query'])) {
            $uri .= $parsed['query'] ? '?' . $parsed['query'] : '';
        }
        if (isset($parsed['fragment'])) {
            $uri .= $parsed['fragment'] ? '#' . $parsed['fragment'] : '';
        }
        return $uri;
    }

}