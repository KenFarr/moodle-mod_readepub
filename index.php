<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/readepub/lib.php');

$id = required_param('id', PARAM_INT); // Course ID

$course = get_course($id);
require_course_login($course);

$PAGE->set_url('/mod/readepub/index.php', ['id' => $id]);
$PAGE->set_title(get_string('modulenameplural', 'readepub'));
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('modulenameplural', 'readepub'));

// Get all instances of the activity in this course
if (!$readepubs = get_all_instances_in_course('readepub', $course)) {
    echo $OUTPUT->notification(get_string('noreadepubs', 'readepub'), 'notifymessage');
    echo $OUTPUT->footer();
    exit;
}

// Prepare the table
$table = new html_table();
$table->head  = [get_string('name'), get_string('bookname', 'readepub')];
$table->align = ['left', 'left'];

foreach ($readepubs as $readepub) {
    $link = html_writer::link(
        new moodle_url('/mod/readepub/view.php', ['id' => $readepub->coursemodule]),
        format_string($readepub->name)
    );

    $table->data[] = [$link, format_string($readepub->bookname)];
}

echo html_writer::table($table);
echo $OUTPUT->footer();
