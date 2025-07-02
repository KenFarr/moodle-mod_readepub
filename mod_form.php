<?php

require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_readepub_mod_form extends moodleform_mod {
    function definition() {
        $mform = $this->_form;

        // Activity name
        $mform->addElement('text', 'name', get_string('name'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        // Description
        $this->standard_intro_elements();

        // Book folder name
        $mform->addElement('text', 'bookname', get_string('bookname', 'readepub'));
        $mform->setType('bookname', PARAM_ALPHANUMEXT);
        $mform->addRule('bookname', null, 'required', null, 'client');

        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }
}
