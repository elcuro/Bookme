<?php

/**
 * Bookme Helper
 *
 * An example hook helper for demonstrating hook system.
 *
 * @category Helper
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class BookmeHelper extends AppHelper {

       /**
        * Other helpers used by this helper
        *
        * @var array
        * @access public
        */
       public $helpers = array(
           'Html',
           'Layout',
       );
       
       /**
        * Show conditionally if is set
        *
        * @param $var
        * @return $var
        */
       public function viewVar($var = '') {
              
              if (!empty($var)) {
                     return $var;
              } else {
                     return $this->Html->tag('em', __('Unattached'), array('class' => 'unnatached'));
              }
       }

       /**
        * Before render callback. Called before the view file is rendered.
        *
        * @return void
        */
       public function beforeRender($viewFile) {
              
       }

       /**
        * After render callback. Called after the view file is rendered
        * but before the layout has been rendered.
        *
        * @return void
        */
       public function afterRender($viewFile) {
              
       }

       /**
        * Before layout callback. Called before the layout is rendered.
        *
        * @return void
        */
       public function beforeLayout($layoutFile) {
              
       }

       /**
        * After layout callback. Called after the layout has rendered.
        *
        * @return void
        */
       public function afterLayout($layoutFile) {
              
       }

       /**
        * Called after LayoutHelper::setNode()
        *
        * @return void
        */
       public function afterSetNode() {
              
       }

       /**
        * Called before LayoutHelper::nodeInfo()
        *
        * @return string
        */
       public function beforeNodeInfo() {
              
       }

       /**
        * Called after LayoutHelper::nodeInfo()
        *
        * @return string
        */
       public function afterNodeInfo() {
       }

       /**
        * Called before LayoutHelper::nodeBody()
        *
        * @return string
        */
       public function beforeNodeBody() {
       }

       /**
        * Called after LayoutHelper::nodeBody()
        *
        * @return string
        */
       public function afterNodeBody() {
       }

       /**
        * Called before LayoutHelper::nodeMoreInfo()
        *
        * @return string
        */
       public function beforeNodeMoreInfo() {
       }

       /**
        * Called after LayoutHelper::nodeMoreInfo()
        *
        * @return string
        */
       public function afterNodeMoreInfo() {
       }

}
