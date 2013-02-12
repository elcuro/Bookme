<div id="bookme-view">
    <?php echo $this->Html->tag('h2', "'".$bookme['Bookme']['name']."' ".__d('bookme', 'booking detail')); ?>
    <dl id="contact">
        <dt><?php echo __d('bookme', 'Name'); ?>:</dt>
        <dd><?php echo h($bookme['Bookme']['name']); ?></dd>
        <dt><?php echo __d('bookme', 'Email'); ?>:</dt>
        <dd><?php echo h($bookme['Bookme']['email']); ?></dd>
        <dt><?php echo __d('bookme', 'Phone'); ?>:</dt>
        <dd><?php echo h($bookme['Bookme']['phone']); ?></dd>
        <dt><?php echo __d('bookme', 'Adress'); ?>:</dt>
        <dd>
            <?php echo h($bookme['Bookme']['adress']); ?>,
            <?php echo h($bookme['Bookme']['city']); ?>,
            <?php echo h($bookme['Bookme']['country']); ?>,
        </dd>    
        <dt><?php echo __d('bookme', 'Note'); ?>:</dt>
        <dd><?php echo h($bookme['Bookme']['note']); ?></dd>
    </dl>
    <dl id="dates">
        <dt><?php echo __d('bookme', 'Dates'); ?>:</dt>
        <dd><strong><?php echo h($bookme['Bookme']['start_text']) . ' - ' . h($bookme['Bookme']['end_text']); ?></strong></dd>
    </dl>
    <dl id="persons">
        <dt><?php echo __d('bookme', 'Persons');?></dt>
        <dd><?php echo h($bookme['Bookme']['persons_count']);?></dd>
    </div>