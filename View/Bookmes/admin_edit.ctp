<?php $this->Html->css('Bookme.bookme_admin.css', null, array('inline' => false));?>
<?php echo $this->Form->create('Bookme'); ?>
<?php $bookme = $this->request->data;?>
<div id="bookme-view">
       <?php echo $this->Html->tag('h2', "'".h($bookme['Bookme']['name'])."' ".__d('bookme', 'booking detail')); ?>
       <dl id="contact">
              <dt><?php echo __d('bookme', 'Name'); ?>:</dt>
              <dd><?php echo $this->Bookme->viewVar($bookme['Bookme']['name']); ?></dd>
              <dt><?php echo __d('bookme', 'Email'); ?>:</dt>
              <dd><?php echo $this->Html->link($bookme['Bookme']['email'], 'mailto:' . $bookme['Bookme']['email']); ?></dd>
              <dt><?php echo __d('bookme', 'Phone'); ?>:</dt>
              <dd><?php echo $this->Bookme->viewVar($bookme['Bookme']['phone']); ?></dd>
              <dt><?php echo __d('bookme', 'Adress'); ?>:</dt>
              <dd>
                     <?php echo $this->Bookme->viewVar($bookme['Bookme']['adress']); ?>,
                     <?php echo $this->Bookme->viewVar($bookme['Bookme']['city']); ?>,
                     <?php echo $this->Bookme->viewVar($bookme['Bookme']['country']); ?>,
              </dd>    
              <dt><?php echo __d('bookme', 'Note'); ?>:</dt>
              <dd><?php echo $this->Bookme->viewVar($bookme['Bookme']['note']); ?></dd>
       </dl>
       <dl id="dates">
              <dt><?php echo __d('bookme', 'Dates'); ?>:</dt>
              <dd><strong><?php echo $bookme['Bookme']['start_text'] . ' - ' . $bookme['Bookme']['end_text']; ?></strong></dd>
       </dl>
       <div id="units">
              <table>
                     <?php
                     $rows = array();
                     foreach ($bookme['Node'] as $node) {
                            $rows[] = array(
                                $this->Html->link($node['title'], array(
                                    'admin' => false,
                                    'plugin' => false,
                                    'controller' => 'nodes',
                                    'action' => 'view',
                                    'slug' => $node['slug'],
                                    'type' => $node['type']
                                )),
                                $node['count'] . 'x'
                            );
                     }
                     $rows[] = array(
                         __d('bookme', 'Total persons'),
                         $bookme['Bookme']['persons_count']
                     );
                     $rows[] = array(
                         __d('bookme', 'Childrens'),
                         $this->Bookme->viewVar($bookme['Bookme']['childrens_count'])
                     );
                     $rows[] = array(
                         __d('bookme', 'Childrens without bed'),
                         $this->Bookme->viewVar($bookme['Bookme']['childrens_wo_bed'])
                     );
                     echo $this->Html->tableCells($rows);
                     ?>
              </table>
       </div>
       <div id="note">
              <?php echo $this->Form->input('our_note', array('label' => __d('bookme', 'Our note'))); ?>
              <?php 
              echo $this->Form->hidden('id');
              echo $this->Form->hidden('type');
              echo $this->Form->hidden('name');
              echo $this->Form->hidden('email');
              echo $this->Form->hidden('phone');
              echo $this->Form->hidden('adress');
              echo $this->Form->hidden('city');              
              echo $this->Form->hidden('country');
              echo $this->Form->hidden('start_text');
              echo $this->Form->hidden('end_text');
              echo $this->Form->hidden('units_count_text');
              echo $this->Form->hidden('persons_count');
              echo $this->Form->hidden('childrens_count');
              ?>
       </div>
       <p class="created"><em><?php echo __d('bookme', 'Booking was received: ') . $this->Time->niceShort($bookme['Bookme']['created']); ?></em></p>
</div>

<?php echo $this->Form->end(__d('bookme', ' Done... ')); ?>