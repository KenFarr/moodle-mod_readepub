<?php

defined('MOODLE_INTERNAL') || die();

function readepub_add_instance($data, $mform) {
    global $DB;

    $data->timecreated = time();
    $data->timemodified = time();

    return $DB->insert_record('readepub', $data);
}

function readepub_update_instance($data, $mform) {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;

    return $DB->update_record('readepub', $data);
}

function readepub_delete_instance($id) {
    global $DB;

    if (!$readepub = $DB->get_record('readepub', ['id' => $id])) {
        return false;
    }

    $DB->delete_records('readepub', ['id' => $id]);

    return true;
}

function readepub_get_coursemodule_info($coursemodule) {
    global $DB;

    if (!$readepub = $DB->get_record('readepub', ['id' => $coursemodule->instance], '*')) {
        return null;
    }

    $info = new cached_cm_info();

    $context = context_module::instance($coursemodule->id);
    $info->name = format_string($readepub->name, true, ['context' => $context]);

    if (!empty($readepub->intro)) {
        $info->content = format_module_intro('readepub', $readepub, $coursemodule->id, false);
    }

    return $info;
}

function readepub_supports($feature) {
    switch ($feature) {

        case FEATURE_MOD_INTRO:
            return true;

        case FEATURE_SHOW_DESCRIPTION:
            return true;

        case FEATURE_BACKUP_MOODLE2:
            return true;

        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;

        case FEATURE_PLAGIARISM:
            return false;

        default:
            return null;
    }
}

function mod_readepub_get_icon() {
    return 'mod_readepub';
}
