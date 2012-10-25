<?php

App::uses('Controller', 'Controller');
App::uses('BookmeHelper', 'Bookme.View/Helper');
App::uses('View', 'View');

class BookmeHelperTest extends CakeTestCase {

       /**
        * View instance
        *
        * @var View
        */
       public $View;

       /**
        * BookmeHelper instance
        *
        * @var BookmeHelper
        */
       public $BookmeHelper;

       public function setUp() {
              parent::setUp();
              $Controller = new Controller();
              $this->View = new View($Controller);
              $this->BookmeHelper = new BookmeHelper($this->View);
       }

       public function testViewVar() {

              $this->assertContains('unnatached', $this->BookmeHelper->viewVar(NULL));
              $this->assertContains('unnatached', $this->BookmeHelper->viewVar());
              $this->assertContains('unnatached', $this->BookmeHelper->viewVar(''));
              $var = array('key' => 'var');
              $this->assertEquals($var, $this->BookmeHelper->viewVar($var));
       }

       public function tearDown() {
              parent::tearDown();
              unset($this->BookmeHelper, $this->View);
       }

}
?>