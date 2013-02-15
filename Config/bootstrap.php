<?php

// Hooks
Croogo::hookHelper('Bookmes', 'Bookme.Bookme');

// Node types for booking
Configure::write('Bookme.nodeTypes', array('accommodation'));

// Validate rules 
Configure::write('Bookme.validateRules', array(
    'start_text' => array(
        'rule' => array('date', 'dmy'),
        'message' => __d('bookme', 'Please enter valid date in dd/mm/yyyy format'),
    ),
    'end_text' => array(
        'rule' => array('date', 'dmy'),
        'message' => __d('bookme', 'Please enter valid date in dd/mm/yyyy format'),
        'required' => true
    ),
    'name' => array(
        'rule' => array('notEmpty'),
        'message' => __d('bokme', 'This field cannot be left blank')
    ),
    'persons_count' => array(
        'rule' => 'numeric',
        'message' => __d('bookme', 'This must be number')
    ),
    'email' => array(
        'rule' => array('email', true),
        'message' => __d('bookme', 'Enter valid email adress')
    )
));

// Navigation
CroogoNav::add('extensions.children.booking', array(
    'title' => __d('bookme', 'Booking'),
    'url' => '#',
    'children' => array(
        'bookings' => array(
            'title' => __d('bookme', 'All bookings'),
            'url' => array('plugin' => 'bookme', 'controller' => 'bookmes', 'action' => 'admin_all')
        ),
        'settings' => array(
            'title' => __d('bookme', 'Settings'),
            'url' => array('plugin' => '', 'controller' => 'settings', 'action' => 'prefix', 'Bookme')
        ),
    )
));
?>