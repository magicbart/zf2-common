<?php

namespace Common\View\Helper;

use Common\Paginator\Paginator;
use Zend\Db\Resultset\Resultset;
use Zend\View\Helper\AbstractHelper;

class DisplayResultset extends AbstractHelper
{
    /**
     * @param Paginator|Resultset $mixed
     * @param string $title
     * @param array $columns
     * @param array|null $route
     * @param array|null $delete
     * @return string
     */
    public function __invoke($mixed, $title, $columns, $route = null, $delete = null)
    {
        if ($mixed instanceof Paginator) {
            $html = sprintf('<h3>%s (%d)</h3>', $title, $mixed->getTotalItemCount());
        } elseif ($mixed instanceof Resultset) {
            $html = sprintf('<h3>%s (%d)</h3>', $title, $mixed->count());
        } else {
            $html = sprintf('<h6>%s (%d)</h6>', $title, $mixed->count());
        }

        $html .= '<div class="tables-wrapper">';
        $html .= '<div class="table-wrapper" id="table_0">';
        $html .= '<table class=" tablesorter">';

        $html .= '<thead>';
        $html .= '<tr>';
        foreach ($columns as $key => $row) {
            $html .= sprintf('<td>%s</td>', $row['label']);
        }
        if ($route != null) {
            $html .= sprintf('<td>%s</td>', $route['label']);
        }
        if ($delete != null) {
            $html .= sprintf('<td>%s</td>', $delete['label']);
        }
        $html .= '</tr>';
        $html .= '</thead>';

        $html .= '<tbody>';
        $count = 0;
        foreach ($mixed as $row) {
            $html .= sprintf('<tr class="%s">', (++$count % 2 ? 'odd' : 'even'));

            foreach ($columns as $key => $tmp) {
                //----- Les colonnes commençant par un underscore sont spéciales
                if (substr($key, 0, 1) == '_') {
                    switch ($key) {
                        case '_edit':

                            break;
                        case '_delete':
                            $title = (isset($tmp['title'])) ? sprintf(' title = "%s"', $tmp['title']) : '';
                            $html .= sprintf(
                                '<td><a href="%s" class="supprime_ano" %s>lien</a></td>',
                                $this->view->url(
                                    $tmp['route']['name'],
                                    array_merge($tmp['route']['params'], array('id' => $row->$tmp['id']))
                                ),
                                $title
                            );
                            break;
                        default:
                            $function = (isset($tmp['function']['name'])) ? $tmp['function']['name'] : 'none';
                            $params = (isset($tmp['function']['params'])) ? $tmp['function']['params'] : array();
                            $html .= sprintf('<td>%s</td>', $this->$function($row, $params));
                            break;
                    }

                } else {
                    $function = (isset($tmp['function']['name'])) ? $tmp['function']['name'] : 'none';
                    $params = (isset($tmp['function']['params'])) ? $tmp['function']['params'] : array();

                    if (isset($tmp['type']) && $tmp['type'] == 'activate') {
                        if ($row->$key) {
                            $html .= '<td><a class="activate" title="Activé">lien</a></td>';
                        } else {
                            $html .= '<td><a class="desactivate" title="Désactivé">lien</a></td>';
                        }
                    } else {
                        $html .= sprintf('<td>%s</td>', $this->$function(nl2br($row->$key), $params));
                    }
                }

            }
            if ($route != null) {
                if (isset($route['title'])) {
                    $title = sprintf(' title = "%s"', $route['title']);
                } else {
                    $title = '';
                }
                $html .= sprintf(
                    '<td><a href="%s" class="modifier" %s >lien</a></td>',
                    $this->view->url($route['route'], array_merge($route['params'], array('id' => $row->$route['id']))),
                    $title
                );
            }
            if ($delete != null) {
                if (isset($delete['title'])) {
                    $title = sprintf(' title = "%s"', $delete['title']);
                } else {
                    $title = '';
                }
                $html .= sprintf(
                    '<td><a href="%s" class="supprime_ano" %s >lien</a></td>',
                    $this->view->url(
                        $delete['route'],
                        array_merge($delete['params'], array('id' => $row->$delete['id']))
                    ),
                    $title
                );
            }

            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }


    public function none($string, $params = array())
    {
        return $string;
    }

    public function link($string, $params = array())
    {
        return sprintf('<a href="' . $params['url'] . '">%s</a>', $params['id'], $string);
    }

    public function export($row, $params = array())
    {
        return sprintf('<a href="' . $params['url'] . '">Téléchargement</a>', $row->$params['id']);
    }

    public function toDate($string, $params = array())
    {
        return $this->view->dateFormat($string);
    }

    public function toDatetime($string, $params = array())
    {
        return $this->view->dateFormat($string, 'd/m/Y H:i:s');
    }


}
