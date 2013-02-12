<?php

/**
* Bookme Controller
*
* PHP version 5
*
* @category Controller
* @package  Croogo
* @version  1.0
* @author   Juraj Jancuska <jjancuska@gmail.com>
* @license  http://www.opensource.org/licenses/mit-license.php The MIT License
* @link     http://www.croogo.org
*/
class BookmesController extends BookmeAppController {

/**
* Controller name
*
* @var string
* @access public
*/
public $name = 'Bookmes';

/**
* Models used by the Controller
*
* @var array
* @access public
*/
public $uses = array(
    'Setting',
    'Nodes',
    'Bookme.Bookme'
    );

/**
* Node types for booking
*
* @var array
* @access public
*/
public $bookingNodeTypes = array();

/**
* Before filter callback
*
* @return void
*/
public function beforeFilter() {

    parent::beforeFilter();
    $this->bookingNodeTypes = Configure::read('Bookme.nodeTypes');
}

/**
* Add booking
*
* @return void
*/
    public function add() {

        if (!empty($this->request->data)) {
            if ($res = $this->Bookme->place($this->request->data)) {
                Croogo::dispatchEvent('Controller.Bookme.afterAdd', $this);
                $this->Session->setFlash(__d('bookme', 'Your booking was successfuly sended'));
                return $this->redirect(array(
                    'plugin' => false,
                    'controller' => 'nodes',
                    'action' => 'promoted')
                );
            }
        }

        if (!isset($this->request->params['named']['type'])) {
            $type = 'accommodation';
        } else {
            $type = $this->request->params['named']['type'];
        }
        if (!in_array($type, $this->bookingNodeTypes)) {
            $this->Session->setFlash(__d('bookme', 'Wrong booking node type'));
            return $this->redirect(array(
                'plugin' => 'bookme',
                'controller' => 'bookmes',
                'action' => 'add')
            );
        }
        $params = array(
            'conditions' => array(
                'Node.type' => $type,
                'Node.status' => 1,
                'OR' => array(
                    'Node.visibility_roles' => '',
                    'Node.visibility_roles LIKE' => '%"' . $this->Croogo->roleId . '"%',
                    )
                ),
        );
        $nodes = $this->Node->find('all', $params);
        if (empty($nodes)) {
            $this->Session->setFlash(__d('bookme', 'No valid units for booking!'));
            return $this->redirect(array(
                'controller' => 'nodes',
                'action' => 'promoted')
            );
        }

        $this->set('title_for_layout', __d('bookme', 'Booking'));
        $this->set(compact('nodes', 'type'));

        $this->_viewFallback(array(
            'add_' . $type));
    }

/**
* Get all bookings
*
* @return void
*/
    public function admin_all() {

        $params = array(
            'order' => 'Bookme.created DESC'
            );
        if (isset($this->params['named']['type'])) {
            $params['conditions'] = array(
                'Bookme.type' => $this->params['named']['type']
                );
        }

        $bookmes = $this->Bookme->find('all', $params);
        $this->set(compact('bookmes'));
    }

/**
* View booking
*
* @param integer $id Booking ID
* @return void
*/
    public function admin_view($id = false) {

        if (!$id || !($bookme = $this->Bookme->findById($id))) {
            $this->Session->setFlash(__d('bookme', 'Invalid booking ID'), 'default', array('class' => 'error'));
            return $this->redirect(array(
                'controller' => 'bookmes',
                'action' => 'admin_all'
                ));
        }
        $this->set(compact('bookme'));
    }

/**
* View booking
*
* @param integer $id Booking ID
* @return void
*/
    public function admin_edit($id = false) {

        if (!empty($this->request->data)) {
            if ($res = $this->Bookme->save($this->request->data)) {
                $this->Session->setFlash(__d('bookme', 'Your booking was successfuly updated'), 'default', array('class' => 'success'));
                return $this->redirect(array(
                    'controller' => 'bookmes',
                    'action' => 'admin_all'
                    ));
            } else {
                $this->Session->setFlash(__d('bookme', 'Error during booking saving!'), 'default', array('class' => 'error'));                         
            }
        }

        if (!$id || !($data = $this->Bookme->findById($id))) {
            $this->Session->setFlash(__d('bookme', 'Invalid booking ID'), 'default', array('class' => 'error'));
            return $this->redirect(array(
                'controller' => 'bookmes',
                'action' => 'admin_all'
                ));
        }
        $this->request->data = $data;
    }

/**
* View fallback
*
* @param array $views
* @return void
*/
    private function _viewFallback($views) {

        if (is_string($views)) {
            $views = array($views);
        }
        if ($this->theme) {
            $viewPaths = App::path('View');
            foreach ($views as $view) {
                foreach ($viewPaths as $viewPath) {
                    $viewPath = $viewPath . 'Themed' . DS . $this->theme . DS .
                    'Plugin' . DS . 'Bookme' . DS . $this->name . DS . $view . $this->ext;
                    if (file_exists($viewPath)) {
                        return $this->render($view);
                    }
                }
            }
        }
    }

}