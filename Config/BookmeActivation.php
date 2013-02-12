<?php

/**
* Bookme Activation
*
* Activation class for Bookme plugin.
*
* @package  Croogo
* @author   Juraj Jancuska <jjancuska@gmail.com>
* @license  http://www.opensource.org/licenses/mit-license.php The MIT License
* @link     http://www.croogo.org
*/
class BookmeActivation {

/**
* Schema directory
*
* @var string
*/
    private $SchemaDir;

/**
* DB connection
*
* @var object
*/
    private $db;

/**
* Plugin name
*
* @var string
*/
    public $pluginName = 'Bookme';

/**
* Constructor
*
* @return vodi
*/
    public function __construct() {

        $this->SchemaDir = APP . 'Plugin' . DS . $this->pluginName . DS . 'Config' . DS . 'Schema';
        $this->db = & ConnectionManager::getDataSource('default');
    }

/**
* onActivate will be called if this returns true
*
* @param  object $controller Controller
* @return boolean
*/
    public function beforeActivation(&$controller) {

        App::uses('CakeSchema', 'Model');
        $CakeSchema = new CakeSchema();

        $all_tables = $this->db->listSources();

        // list schema files from config/schema dir
        if (!$cake_schema_files = $this->_listSchemas($this->SchemaDir))
            return false;

        // create table for each schema
        foreach ($cake_schema_files as $schema_file) {
            $schema_name = substr($schema_file, 0, -4);
            $schema_class_name = Inflector::camelize($schema_name) . 'Schema';
            $table_name = $schema_name;

            include_once($this->SchemaDir . DS . $schema_file);
            $ActiveSchema = new $schema_class_name;

            if (!in_array($table_name, $all_tables)) {
            // create table
                if (!$this->db->execute($this->db->createSchema($ActiveSchema, $table_name))) {
                    return false;
                }
            }
        }
        return true;
    }

/**
* Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
*
* @param object $controller Controller
* @return void
*/
    public function onActivation(&$controller) {

        $controller->Croogo->addAco('Bookmes');
        $controller->Croogo->addAco('Bookmes/admin_all');
        $controller->Croogo->addAco('Bookmes/admin_edit');
        $controller->Croogo->addAco('Bookmes/add', array('registered', 'public'));    

        $controller->Setting->write('Bookme.email', Configure::read('Site.email'), array(
            'editable' => 1, 'description' => __d('bookme', 'Email for receiving bookings'))
        );  
        $controller->Setting->write('Bookme.maxVacancy', '10', array(
            'editable' => 1, 'description' => __d('bookme', 'Max. vacancy of resort'))
        );                                              
    }

/**
* onDeactivate will be called if this returns true
*
* @param  object $controller Controller
* @return boolean
*/
    public function beforeDeactivation(&$controller) {

    // list schema files from config/schema dir
    /*if (!$cake_schema_files = $this->_listSchemas($this->SchemaDir))
    return false;

    // delete tables for each schema
    foreach ($cake_schema_files as $schema_file) {
    $schema_name = substr($schema_file, 0, -4);
    $table_name = $schema_name;
    if (!$this->db->execute('DROP TABLE ' . $table_name)) {
    return false;
    }
    }*/
    return true;
    }

/**
* Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
*
* @param object $controller Controller
* @return void
*/
    public function onDeactivation(&$controller) {

        $controller->Croogo->removeAco('Bookmes');
    }

/**
* List schemas
*
* @param string $dir Directory where searching for schema files
* @return array
*/
    private function _listSchemas($dir = false) {

        if (!$dir)
            return false;

        $cake_schema_files = array();
        if ($h = opendir($dir)) {
            while (false !== ($file = readdir($h))) {
                if (($file != ".") && ($file != "..") && ($file != ".svn")) {
                    $cake_schema_files[] = $file;
                }
            }
        } else {
            return false;
        }

        return $cake_schema_files;
    }

}