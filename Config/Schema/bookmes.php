<?php

class BookmesSchema extends CakeSchema {

       /**
        * Schema name
        *
        * @var string
        */
       public $name = 'Bookmes';

       /**
        * CakePHP schema
        *
        * @var array
        */
       public $bookmes = array(
           'id' => array('type' => 'integer', 'null' => false, 'lenght' => 8, 'key' => 'primary'),
           'type' => array('type' => 'string', 'null' => false, 'length' => 200),
           'start_text' => array('type' => 'string', 'null' => false, 'length' => 100),
           'end_text' => array('type' => 'string', 'null' => false, 'length' => 100),
           'units_count_text' => array('type' => 'text', 'null' => false),
           'persons_count' => array('type' => 'integer', 'null' => false, 'length' => 2, 'default' => 1),
           'childrens_count' => array('type' => 'integer', 'null' => true, 'length' => 2, 'default' => 0),
           'childrens_wo_bed' => array('type' => 'integer', 'null' => true, 'length' => 1, 'default' => 0),
           'name' => array('type' => 'string', 'null' => false, 'length' => 200),
           'adress' => array('type' => 'string', 'null' => true, 'length' => 200),
           'city' => array('type' => 'string', 'null' => true, 'length' => 200),
           'country' => array('type' => 'string', 'null' => false, 'length' => 200),
           'email' => array('type' => 'string', 'null' => false, 'length' => 200),
           'phone' => array('type' => 'string', 'null' => false, 'length' => 200),
           'note' => array('type' => 'text', 'null' => true),
           'our_note' => array('type' => 'text', 'null' => true),
           'updated' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
           'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
           'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
       );

       /**
        * Before callback
        *
        * @param array $event
        * @return void
        */
       public function before($event = array()) {
              
       }

       /**
        * After callback
        *
        * @param array $event
        * @return void
        */
       public function after($event = array()) {
              
       }

}

?>