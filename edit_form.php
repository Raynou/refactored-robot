<?php

class block_simplecamera_edit_form extends block_edit_form {
        
    protected function specific_definition($mform) {
        
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_period', get_string('cameraperiod', 'block_simplecamera'));
        $mform->setDefault('config_period', 10);
        $mform->setType('config_period', PARAM_INT);        

    }
}
