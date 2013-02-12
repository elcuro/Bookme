<?php
/**
* Bookme model
*
* @author Juraj Jancuska <jjancuska@gmail.com>
* @copyright (c) 2010 Juraj Jancuska
* @license MIT License - http://www.opensource.org/licenses/mit-license.php
*/
class Bookme extends BookmeAppModel {

/**
* validation rules
*
* @var array
*/
    public $validate = array(
        'type' => array(
            'rule' => array('notEmpty'),
            'message' => 'Node type of booking not specified',
            'required' => true
            )
        );

/**
* Model name
*
* @var string
*/
    public $name = 'Bookme';

/**
* Model constructor
*
* @param $id
* @param $table
* @param $ds
* @return void
*/
    public function __construct($id = false, $table = null, $ds = null) {

        $this->validate = array_merge(Configure::read('Bookme.validateRules'), $this->validate);
        parent::__construct($id, $table, $ds);
    }

/**
* Place new booking
*
* @param array $data
* @return void
*/
    public function place($data = array()) {

        if (!empty($data['Unit'])) {
            $data['Bookme']['units_count_text'] = serialize($data['Unit']);
            unset($data['Unit']);
            if ($res = $this->save($data)) {
                return $res;
            }
        }
        return false;
    }

/**
* After find callback
*
* @param array $result 
* @param boolean $primary
* @return array
*/
    public function afterFind($result, $primary = false) {

        foreach ($result as $key => $val) {
            if (isset($val['Bookme'])) {
                $result[$key]['Node'] = $this->_getNodes(unserialize($val['Bookme']['units_count_text']));
            }
        }
        return $result;
    }

/**
* Get nodes with count for booking
*
* @param array $units_count Units count key=node_id val=count
* @return array
*/
    protected function _getNodes($units_count = array()) {
        $ret = array();

        if (!empty($units_count)) {
            $cond = array();
            foreach ($units_count as $node_id => $count) {
                $cond[] = array('Node.id' => $node_id);
            }
            $params = array(
                'conditions' => array(
                    'OR' => $cond
                    ),
                'cache' => array(
                    'name' => 'bookme_nodes_' . md5(serialize($cond)),
                    'config' => 'nodes_index'
                    )
                );

            App::uses('Node', 'Model');
            $Node = ClassRegistry::init('Node');

            $Node->recursive = -1;
            $nodes = $Node->find('all', $params);
            foreach ($nodes as $node) {
                $node['Node']['count'] = $units_count[$node['Node']['id']];
                $ret[] = $node['Node'];
            }
        }

        return $ret;
    }
}
?>