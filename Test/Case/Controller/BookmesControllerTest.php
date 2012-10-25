<?php

App::uses('CroogoControllerTestCase', 'TestSuite');

class BookmesControllerTest extends CroogoControllerTestCase {

       public $fixtures = array(
           'aco',
           'aro',
           'aros_aco',
           'block',
           'comment',
           'contact',
           'i18n',
           'language',
           'link',
           'menu',
           'message',
           'meta',
           'plugin.bookme.node',
           'nodes_taxonomy',
           'region',
           'role',
           'setting',
           'taxonomy',
           'term',
           'type',
           'types_vocabulary',
           'user',
           'vocabulary',
           'plugin.bookme.bookme'
       );
       public $postData = array(
           'Unit' => array(1 => 14, 2 => 10),
           'Bookme' => array(
               'start_text' => '22/1/2013',
               'end_text' => '25/1/2013',
               'type' => 'accommodation',
               'name' => 'sample name',
               'email' => 'sample@gmail.com',
               'created' => '2012-07-04 10:43:23',
               'updated' => '2012-07-04 10:49:51')
       );

       public function testAdminAllWithoutType() {

              $this->testAction('/admin/bookme/bookmes/all');
              $this->assertInternalType('array', $this->vars['bookmes']);
              $this->assertEquals(3, count($this->vars['bookmes']));
       }

       public function testAdminAllWithType() {

              $this->testAction('/admin/bookme/bookmes/all/type:accommodation');
              $this->assertInternalType('array', $this->vars['bookmes']);
              $this->assertEquals(2, count($this->vars['bookmes']));
       }

       public function testAdminAllWithWrongType() {

              $this->testAction('/admin/bookme/bookmes/all/type:scifi');
              $this->assertInternalType('array', $this->vars['bookmes']);
              $this->assertEquals(0, count($this->vars['bookmes']));
       }

       public function testAdminView() {

              $this->testAction('/admin/bookme/bookmes/view/3');
              $this->assertEquals('Homer', $this->vars['bookme']['Bookme']['name']);
              $this->assertEquals(2, count($this->vars['bookme']['Node']));
       }

       public function testAdminViewWrongId() {

              $this->testAction('/admin/bookme/bookmes/view/100');
              $this->assertFalse(isset($this->vars['bookme']['Bookme']));
              $this->assertContains('/bookme/bookmes/all', $this->headers['Location']);
       }

       public function testAdminEdit() {

              $postData = array(
                  'Bookme' => array(
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
                      'our_note' => 'Note update'
                  )
              );
              $this->testAction('/admin/bookme/bookmes/edit/2', array(
                  'data' => $postData,
                  'method' => 'post'
              ));
              $result = $this->controller->Bookme->findById(2);
              $this->assertEquals('Note update', $result['Bookme']['our_note']);
       }

       public function testAddWithoutPostData() {

              Configure::write('Cache.disable', true);

              $this->testAction('/bookme/bookmes/add');
              $this->assertEquals('accommodation', $this->vars['type']);
              $this->assertEquals(2, count($this->vars['nodes']));
       }

       public function testAddWithTypeWithoutPostData() {

              Configure::write('Bookme.nodeTypes', array('accommodation', 'conference'));
              $this->testAction('/bookme/bookmes/add/type:conference');

              $this->assertEquals('conference', $this->vars['type']);
              $this->assertEquals(1, count($this->vars['nodes']));

              $conf_node = Set::extract($this->vars['nodes'], '/Node[slug=conference-room]');
              $this->assertFalse(empty($conf_node));
       }

       public function testAddWrongNodeType() {

              $this->testAction('/bookme/bookmes/add/type:conference');

              $this->assertFalse(isset($this->vars['nodes']));
              $this->assertContains('/bookme/bookmes/add', $this->headers['Location']);
       }

       public function testAddNoValidNodes() {

              Configure::write('Bookme.nodeTypes', array('accommodation', 'conference', 'event'));

              $this->testAction('/bookme/bookmes/add/type:event');

              $this->assertFalse(isset($this->vars['nodes']));
              $this->assertContains('/nodes/promoted', $this->headers['Location']);
       }

       /*
        * Tessting viewFallback require themed view in
        * /app/Test/test_app/View/Themed/Mytheme/Plugin/Bookme/Bookmes/add_accommodation.ctp
        */
       public function testAddViewFallback() {

              $this->generate('Bookme.Bookmes');
              $this->controller->theme = 'Mytheme';
              $this->testAction('/bookme/bookmes/add/type:accommodation');
              $this->assertContains('bookme add_accommodation.ctp', $this->contents);
       }

       public function testAddPostData() {

              $postData = $this->postData;
              $this->testAction('/bookme/bookmes/add', array(
                  'data' => $postData,
                  'method' => 'post'
              ));

              $expected = array(0 => array(
                      'Bookme' => array(
                          'id' => '4',
                          'type' => 'accommodation',
                          'start_text' => '22/1/2013',
                          'end_text' => '25/1/2013',
                          'units_count_text' => 'a:2:{i:1;i:14;i:2;i:10;}',
                          'persons_count' => '1',
                          'childrens_count' => '0',
                          'childrens_wo_bed' => '0',
                          'name' => 'sample name',
                          'adress' => null,
                          'city' => null,
                          'country' => '',
                          'email' => 'sample@gmail.com',
                          'phone' => '',
                          'note' => null,
                          'our_note' => null,
                          'updated' => '2012-07-04 10:49:51',
                          'created' => '2012-07-04 10:43:23')
                      ));

              $result = $this->controller->Bookme->find('all');
              $this->assertEquals($expected, Set::extract($result, '/Bookme[email=sample@gmail.com]'));
              $this->assertEquals(4, count($result));
       }

       public function testAddEmptyType() {

              $postData = $this->postData;
              unset($postData['Bookme']['type']);
              $this->testAction('/bookme/bookmes/add', array(
                  'data' => $postData,
                  'method' => 'post'
              ));

              $this->assertTrue(isset($this->controller->Bookme->validationErrors['type']));
              $this->assertEquals(3, $this->controller->Bookme->find('count'));
       }

}
?>