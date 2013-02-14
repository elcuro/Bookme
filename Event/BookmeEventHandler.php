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
            $email = new CakeEmail();
            $email->config(Configure::read('Bookme.emailConfig'))
                ->template('Bookme.booking_confirm_'.$controller->request->data['Bookme']['type'])
                ->emailFormat('html')
                ->subject(__d('bookme', 'Booking information'))
                ->from(array($admin_email => Configure::read('Site.title')))
                ->to($controller->request->data['Bookme']['email'])
                ->bcc($admin_email)
                ->viewVars(array('bookme' => $controller->request->data));

            $themed = Configure::read('Bookme.emailConfig.useTheme');
            if ($themed && isset($controller->theme)) {
                $email->theme($controller->theme); // theme require CakePHP 2.2+
            }
            if (!$email->send()) {
                $controller->Session->setFlash(__d('bookme', 'Error during sending email confirmation'), 'default', array('class' => 'error'));
            }
        }
    }
}