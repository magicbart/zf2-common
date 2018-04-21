<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

class AddThis extends AbstractHelper
{

    /**
     * __invoke
     *
     * @access public
     * @return String
     */
    public function __invoke($id)
    {
        return '
<div id="addthis">
    <div class="addthis_toolbox addthis_default_style">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet"></a>
        <a class="addthis_button_google_plusone"></a>
        <a class="addthis_counter addthis_pill_style"></a>
    </div>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=' . $id . '"></script>
</div>';
    }
}
