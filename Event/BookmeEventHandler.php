<?php

/**
 * Bookme event handler
 *
 * PHP version 5
 *
 * @category Event
 * @package  Croogo
 * @version  1.0
 * @author   Juraj Jancuska <jjancuska@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class BookmeEventHandler extends Object implements CakeEventListener {

       /**
        * implementedEvents
        *
        * @return array
        */
       public function implementedEvents() {
              return array(
                  'Model.Bookme.afterAdd' => array(
                      'callable' => 'onBookmeAfterAdd',
                  )
              );
       }
       
       /**
        * onBookmeAfterAdd
        *
        * @param CakeEvent $event
        * @return void
        */
       public function onBookmeAfterAdd($event) {
              
              // send notification mails
       }
}