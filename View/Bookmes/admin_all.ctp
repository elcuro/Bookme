<?php echo $this->Html->tag('h2', __('Bookings'));?>
<table cellpadding="0" cellspacing="0">
       <?php       
       $tableHeaders = array(
           __('Name'),
           __('Email'),
           __('Date'),
           __('Persons'),
           __('Recieved'),
           __('Actions')
       );
       echo $this->Html->tableHeaders($tableHeaders);
       
       $rows = array();
       foreach ($bookmes as $book) {
             $rows[] = array(
                 $book['Bookme']['name'],
                 $this->Html->link($book['Bookme']['email'], 'mailto:'.$book['Bookme']['email']),
                 $book['Bookme']['start_text'].' - '.$book['Bookme']['end_text'],
                 $book['Bookme']['persons_count'],
                 $this->Time->niceShort($book['Bookme']['created']),
                 $this->Html->link(__('View'), array(
                     'plugin' => 'bookme',
                     'controller' => 'bookmes',
                     'action' => 'edit',
                     $book['Bookme']['id']
                 ))
             ); 
       }
       echo $this->Html->tableCells($rows);
       echo $this->Html->tableHeaders($tableHeaders);
       ?>
</table>   