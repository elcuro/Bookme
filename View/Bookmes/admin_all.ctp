<?php echo $this->Html->tag('h2', __d('bookme', 'Bookings'));?>
<table cellpadding="0" cellspacing="0">
       <?php       
       $tableHeaders = array(
           __d('bookme', 'Name'),
           __d('bookme', 'Email'),
           __d('bookme', 'Date'),
           __d('bookme', 'Persons'),
           __d('bookme', 'Recieved'),
           __d('bookme', 'Actions')
       );
       echo $this->Html->tableHeaders($tableHeaders);
       
       $rows = array();
       foreach ($bookmes as $book) {
             $rows[] = array(
                 h($book['Bookme']['name']),
                 $this->Html->link(h($book['Bookme']['email']), 'mailto:'.h($book['Bookme']['email'])),
                 h($book['Bookme']['start_text']).' - '.h($book['Bookme']['end_text']),
                 h($book['Bookme']['persons_count']),
                 $this->Time->niceShort($book['Bookme']['created']),
                 $this->Html->link(__d('bookme', 'View'), array(
                     'plugin' => 'bookme',
                     'controller' => 'bookmes',
                     'action' => 'edit',
                     h($book['Bookme']['id'])
                 ))
             ); 
       }
       echo $this->Html->tableCells($rows);
       echo $this->Html->tableHeaders($tableHeaders);
       ?>
</table>   