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
 * Returns all instances of this module in the given course.
 *
 * @param int $courseid
 * @return array of instances
 */
function readepub_get_coursemodule_info($coursemodule) {
    global $DB;

    $info = null;

    if ($readepub = $DB->get_record('readepub', ['id' => $coursemodule->instance], '*')) {
        $info = new cached_cm_info();
        $info->name = $readepub->name;
    }

    return $info;
}
