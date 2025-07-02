<?php

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('readepub', $id, 0, false, MUST_EXIST);
$context = context_module::instance($cm->id);

require_course_login($cm->course, true, $cm);

$readepub = $DB->get_record('readepub', ['id' => $cm->instance], '*', MUST_EXIST);

$PAGE->set_url('/mod/readepub/view.php', ['id' => $cm->id]);
$PAGE->set_title($readepub->name);
$PAGE->set_heading($COURSE->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($readepub->name));

echo format_module_intro('readepub', $readepub, $cm->id);

// Embed the Bibi reader
$bookurl = new moodle_url('/mod/readepub/bibi/index.php', ['book' => $readepub->bookname]);
echo html_writer::tag('iframe', '', [
    'src' => $bookurl->out(),
    'style' => 'width:100%;height:600px;border:0;'
]);

echo $OUTPUT->footer();
