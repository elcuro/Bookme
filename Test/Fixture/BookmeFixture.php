<?php

class BookmeFixture extends CroogoTestFixture {

       public $name = 'Bookme';
       public $fields = array(
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
       public $records = array(
           array(
               'id' => 1,
               'type' => 'accommodation',
               'start_text' => '14/3/2013',
               'end_text' => '24/4/2013',
               'units_count_text' => 'a:1:{i:3;i:10;}',
               'persons_count' => 10,
               'childrens_count' => 0,
               'childrens_wo_bed' => 0,
               'name' => 'Fantomas',
               'adress' => 'Moulin Rouge 666',
               'city' => 'Paris',
               'country' => 'France',
               'email' => 'fantomas@gmail.com',
               'phone' => '666666',
               'note' => 'I\'ll be back',
               'our_note' => 'Important!!!'
           ),
           array(
               'id' => 2,
               'type' => 'conference',
               'start_text' => '1/1/2013',
               'end_text' => '2/2/2013',
               'units_count_text' => 'a:1:{i:5;i:1;}',
               'persons_count' => 99,
               'childrens_count' => 3,
               'childrens_wo_bed' => 3,
               'name' => 'kpt. Kirk',
               'adress' => 'Enterprise',
               'city' => '',
               'country' => '',
               'email' => 'enterprise@gmail.com',
               'phone' => '1234567',
               'note' => 'cpt our',
               'our_note' => 'From universe'
           ),
           array(
               'id' => 3,
               'type' => 'accommodation',
               'start_text' => '14/3/2013',
               'end_text' => '24/4/2013',
               'units_count_text' => 'a:2:{i:3;i:10;i:4;i:2;}',
               'persons_count' => 5,
               'childrens_count' => 2,
               'childrens_wo_bed' => 1,
               'name' => 'Homer',
               'adress' => '',
               'city' => 'Springfield',
               'country' => 'Usa',
               'email' => 'homer@gmail.com',
               'phone' => '',
               'note' => '',
               'our_note' => 'OMG Simpsons...'
           ),           
       );

}
