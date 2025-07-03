<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Add a readepub instance.
 *
 * @param object $data
 * @param object $mform
 * @return int new instance id
 */
function readepub_add_instance($data, $mform) {
    global $DB;

    $data->timecreated = time();
    $data->timemodified = time();

    return $DB->insert_record('readepub', $data);
}

/**
 * Update a readepub instance.
 *
 * @param object $data
 * @param object $mform
 * @return bool
 */
function readepub_update_instance($data, $mform) {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;

    return $DB->update_record('readepub', $data);
}

/**
 * Delete a readepub instance.
 *
 * @param int $id
 * @return bool
 */
function readepub_delete_instance($id) {
    global $DB;

    if (!$readepub = $DB->get_record('readepub', ['id' => $id])) {
        return false;
    }

    return $DB->delete_records('readepub', ['id' => $id]);
}

/**
 * Return a list of participants (required stub).
 */
function readepub_get_participants($readepubid) {
    return [];
}

/**
 * Return information for course module display.
 *
 * This enables the description to be shown on the course page when "Display description" is checked.
 *
 * @param cm_info $coursemodule
 * @return cached_cm_info|null
 */
function readepub_get_coursemodule_info($coursemodule) {
    global $DB;

    if (!$readepub = $DB->get_record('readepub', ['id' => $coursemodule->instance], '*')) {
        return null;
    }

    $info = new cached_cm_info();
    $info->name = $readepub->name;

    // This enables the description to be shown on the course page
    if (!empty($readepub->intro)) {
        $info->content = format_module_intro('readepub', $readepub, $coursemodule->id, false);
    }

    return $info;
}

/**
 * Declare supported features.
 *
 * @param string $feature FEATURE_xx constant
 * @return mixed True if supported, null otherwise
 */
function readepub_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        default:
            return null;
    }
}

/**
 * Get icon for the activity (SVG).
 */
function mod_readepub_get_icon() {
    return 'mod_readepub';
}
