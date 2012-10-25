<?php

// Hooks
Croogo::hookHelper('Bookmes', 'Bookme.Bookme');

// Node types for booking
Configure::write('Bookme.nodeTypes', array('accommodation'));

// Validate rules 
Configure::write('Bookme.validateRules', array(
    'start_text' => array(
        'rule' => array('date', 'dmy'),
        'message' => 'Please enter valid date in dd/mm/yyyy format',
    ),
    'end_text' => array(
        'rule' => array('date', 'dmy'),
        'message' => 'Please enter valid date in dd/mm/yyyy format',
        'required' => true
    ),
    'name' => array(
        'rule' => array('notEmpty'),
        'message' => 'This field cannot be left blank'
    ),
    'persons_count' => array(
        'rule' => 'numeric',
        'message' => 'This must be number'
    ),
    'email' => array(
        'rule' => array('email', true),
        'message' => 'Enter valid email message'
    )
));

// Navigation
CroogoNav::add('extensions.children.booknig', array(
    'title' => __('Booking'),
    'url' => '#',
    'children' => array(
        'settings' => array(
            'title' => __('All bookings'),
            'url' => array('plugin' => 'bookme', 'controller' => 'bookmes', 'action' => 'admin_all')
        )
    )
));
?>