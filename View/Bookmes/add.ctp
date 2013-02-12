<?php
$this->Html->script('http://code.jquery.com/ui/1.9.2/jquery-ui.min.js', array('inline' => false));
$this->Html->css('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css', null, array('inline' => false));
?>
<div class="booking <?php echo $type; ?>">

    <?php echo $this->Form->create('Bookme'); ?>
    <div id="dates">
        <?php
        echo $this->Form->input('start_text', array('label' => __d('bookme', 'Start date')));
        echo $this->Form->input('end_text', array('label' => __d('bookme', 'End date')));
        ?>
    </div>
    <table id="units">
        <tr>
            <th><?php echo __d('bookme', 'Unit'); ?></th>
            <th><?php echo __d('bookme', 'Unit count'); ?></th>
            <th></th>
        </tr>
        <?php
        foreach ($nodes as $node) {
            $this->Layout->setNode($node);
            $row = $this->Html->tag('td', $this->Html->link($this->Layout->node('title'), $this->Layout->node('url')));
            $row .= $this->Html->tag('td', $this->Form->text('Unit.' . $this->Layout->node('id'), array('value' => 0, 'size' => 1)));

            if (isset($node['CustomFields']['bookme_unit_count'])) {
                $row .= $this->Html->tag('td', $this->Html->tag('em', 'max. ' . $node['CustomFields']['bookme_unit_count']));
            }
            echo $this->Html->tag('tr', $row);
        };
        ?>
    </table>

    <div id="counts">
        <?php
        echo $this->Form->input('persons_count', array('label' => __d('bookme', 'Total persons')));
        echo $this->Form->input('childrens_count', array('label' => __d('bookme', 'Childrens')));
        echo $this->Form->input('childrens_wo_bed', array('label' => __d('bookme', 'Childrens without bed')))
        ?>
    </div>

    <div id="contacts">
        <?php
        echo $this->Form->input('name', array('label' => __d('bookme', 'Name')));
        echo $this->Form->input('adress', array('label' => __d('bookme', 'Adress')));
        echo $this->Form->input('city', array('label' => __d('bookme', 'City')));
        echo $this->Form->input('country', array('label' => __d('bookme', 'Country')));
        echo $this->Form->input('email', array('label' => __d('bookme', 'Email')));
        echo $this->Form->input('phone', array('label' => __d('bookme', 'Phone')));
        echo $this->Form->hidden('type', array('value' => $type))
        ?>
    </div>

    <div id="note">
        <?php
        echo $this->Form->input('note', array('label' => __d('bookme', 'Note'), 'type' => 'textarea'));
        ?>
    </div>

    <?php echo $this->Form->end(__d('bookme', 'Book now')); ?>
</div>

<script>
$(document).ready(function(){                    
    $("#BookmeStartText, #BookmeEndText").datepicker({
        firstDay: 1,
        minDate: 0,
        dateFormat: 'dd/mm/yy'
    });
});
</script>