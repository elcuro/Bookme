<?php
App::uses('CakeEmail', 'Network/Email');
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
* ImplementedEvents
*
* @return array
*/
    public function implementedEvents() {
        return array(
            'Controller.Bookme.afterAdd' => array(
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

        $controller = $event->subject();

        $admin_email = Configure::read('Bookme.email');
        if (!empty($admin_email)) {
            $controller->Email->from = Configure::read('Site.title') . ' ' .
                '<'.$admin_email. '>';
            $controller->Email->to = $controller->request->data['Bookme']['email'];
            $controller->Email->bcc =  array($admin_email);
            $controller->Email->subject = __d('bookme', 'Booking information');
            $controller->Email->sendAs = 'html';
            $controller->Email->template = 'Bookme.booking_confirm_'.$controller->request->data['Bookme']['type'];
            $controller->Email->send();            
        }
    }
}