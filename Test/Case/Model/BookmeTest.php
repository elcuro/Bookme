<?php
App::uses('Model', 'Model');
App::uses('AppModel', 'Model');
App::uses('BookmeAppModel', 'Bookme.Model');
App::uses('Bookme', 'Bookme.Model');
App::uses('CroogoTestCase', 'TestSuite');

class TestBookme extends Bookme {
       
       public $name = 'Bookme';
       public $alias = 'Bookme';
       
       public function getNodes($params) {
              $ret = $this->_getNodes($params);
              return $ret;
       }
}

class BookmeTest extends CroogoTestCase {

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
       public $Bookme;
       public $postData = array(
           'Unit' => array(1 => 14),
           'Bookme' => array(
               'start_text' => '22/1/2013',
               'end_text' => '25/1/2013',
               'type' => 'accommodation',
               'name' => 'sample name',
               'email' => 'sample@gmail.com',
               'created' => '2012-07-04 10:43:23',
               'updated' => '2012-07-04 10:49:51')
       );
       public $tmpPostData = array();       

       public function setUp() {
              parent::setUp();
              $this->Bookme = ClassRegistry::init('TestBookme');
              $this->tmpPostData = $this->postData;
       }

       public function tearDown() {
              parent::tearDown();
              unset($this->Bookme);
              $this->tmpPostData = array();
       }

       public function testPlaceNoUnit() {
              unset($this->tmpPostData['Unit']);

              $recs_before = $this->Bookme->find('count');
              $res = $this->Bookme->place($this->tmpPostData);
              $recs_after = $this->Bookme->find('count');

              $this->assertFalse($res);
              $this->assertEqual($recs_after, $recs_before);
       }

       public function testPlaceUnitEmptyArray() {
              $this->tmpPostData['Unit'] = array();

              $recs_before = $this->Bookme->find('count');
              $res = $this->Bookme->place($this->tmpPostData);
              $recs_after = $this->Bookme->find('count');

              $this->assertFalse($res);
              $this->assertEqual($recs_after, $recs_before);
       }

       public function testPlace() {
              $recs_before = $this->Bookme->find('count');
              $res = $this->Bookme->place($this->tmpPostData);
              $recs_after = $this->Bookme->find('count');

              $expected = 'a:1:{i:1;i:14;}';

              $this->assertTrue($recs_after != $recs_before);
              $this->assertEqual($recs_after, $recs_before + 1);
              $this->assertEqual($expected, $res['Bookme']['units_count_text']);
       }

       public function testEmptyName() {
              $this->tmpPostData['Bookme']['name'] = '';
              $res = $this->Bookme->place($this->tmpPostData);
              $invalid_fields = $this->Bookme->invalidFields();

              $this->assertFalse($res);
              $this->assertTrue(!empty($invalid_fields['name']));
       }

       public function testEmptyEmail() {
              $this->tmpPostData['Bookme']['email'] = '';
              $res = $this->Bookme->place($this->tmpPostData);
              $invalid_fields = $this->Bookme->invalidFields();

              $this->assertFalse($res);
              $this->assertTrue(!empty($invalid_fields['email']));
       }

       public function testWrongEmail() {
              $this->tmpPostData['Bookme']['email'] = 'asdai@ssfsdf';
              $res = $this->Bookme->place($this->tmpPostData);
              $invalid_fields = $this->Bookme->invalidFields();

              $this->assertFalse($res);
              $this->assertTrue(!empty($invalid_fields['email']));
       }

       public function testEmptyDate() {

              $this->tmpPostData['Bookme']['start_text'] = '';
              $res = $this->Bookme->place($this->tmpPostData);
              $invalid_fields = $this->Bookme->invalidFields();

              $this->assertFalse($res);
              $this->assertTrue(!empty($invalid_fields['start_text']));
       }

       public function testWrongDate() {

              $this->tmpPostData['Bookme']['end_text'] = '20/20/2001';
              $res = $this->Bookme->place($this->tmpPostData);
              $invalid_fields = $this->Bookme->invalidFields();

              $this->assertFalse($res);
              $this->assertTrue(!empty($invalid_fields['end_text']));
       }

       public function testEmptyType() {

              unset($this->tmpPostData['Bookme']['type']);
              $res = $this->Bookme->place($this->tmpPostData);
              $invalid_fields = $this->Bookme->invalidFields();

              $this->assertFalse($res);
              $this->assertTrue(!empty($invalid_fields['type']));
       }

       public function testGetNodes() {
              
              $units_count = array('3' => 10, '4' => 15);              
              $expected = array(
                  'id' => 3,
                  'parent_id' => null,
                  'user_id' => 1,
                  'title' => 'King apartment',
                  'slug' => 'king-apartment',
                  'body' => '<p>This is an example of a king apartment, you could edit this to put information about yourself or your site.</p>',
                  'excerpt' => '',
                  'status' => 1,
                  'mime_type' => '',
                  'comment_status' => 0,
                  'comment_count' => 0,
                  'promote' => 0,
                  'path' => '/king-apartment',
                  'terms' => '',
                  'sticky' => 0,
                  'lft' => 1,
                  'rght' => 2,
                  'visibility_roles' => '',
                  'count' => 10,
                  'type' => 'accommodation',
                  'updated' => '2009-12-25 22:00:00',
                  'created' => '2009-12-25 22:00:00'
              );

              $result = $this->Bookme->getNodes($units_count);
              unset($result[0]['url']);
              $this->assertEquals($expected, $result[0]);
              $this->assertEquals(2, count($result));
       }

       public function testFindFirst() {

              $params = array(
                  'conditions' => array(
                      'type' => 'accommodation',
                      'name' => 'Homer'
                  )
              );
              $result = $this->Bookme->find('first', $params);
              $this->assertEquals('Homer', $result['Bookme']['name']);
              $this->assertEquals(2, count($result['Node']));
              $this->assertEquals(10, $result['Node'][0]['count']);
       }

       public function testFindMore() {

              $params = array(
                  'conditions' => array(
                      'type' => 'accommodation'
                  )
              );
              $result = $this->Bookme->find('all', $params);
              $this->assertEquals(2, count($result));
              $this->assertEquals('Fantomas', $result[0]['Bookme']['name']);
              $this->assertEquals(2, $result[1]['Node'][1]['count']);
       }

}
?>