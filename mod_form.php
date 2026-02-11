<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');

class mod_readepub_mod_form extends moodleform_mod {

    public function definition() {
        $mform = $this->_form;

        // Activity name
        $mform->addElement('text', 'name', get_string('name'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        // Description
        $this->standard_intro_elements();

        // Book folder name
        $mform->addElement('text', 'bookname', get_string('bookname', 'mod_readepub'));
        $mform->setType('bookname', PARAM_ALPHANUMEXT);
        $mform->addRule('bookname', null, 'required', null, 'client');

        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (empty($data['bookname'])) {
            $errors['bookname'] = get_string('required');
        }

        return $errors;
    }
}
