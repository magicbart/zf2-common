<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class GoogleAnalytics extends AbstractHelper
{

    /**
     * __invoke
     *
     * @access public
     * @return String
     */
    public function __invoke($id)
    {
        if (APPLICATION_ENV == 'prod') {
            return "<script type=\"text/javascript\">
              var _gaq = _gaq || [];
              _gaq.push(['_setAccount', '$id']);
              _gaq.push(['_trackPageview']);

              (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
              })();

            </script>";
        }
    }


}
