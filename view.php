<?php

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

$id = required_param('id', PARAM_INT); // Course module ID
$cm = get_coursemodule_from_id('readepub', $id, 0, false, MUST_EXIST);
$context = context_module::instance($cm->id);
require_course_login($cm->course, true, $cm);

$readepub = $DB->get_record('readepub', ['id' => $cm->instance], '*', MUST_EXIST);

// Build the URL to launch
$bookurl = new moodle_url('/mod/readepub/bibi/index.php', ['book' => $readepub->bookname]);

$PAGE->set_url('/mod/readepub/view.php', ['id' => $cm->id]);
$PAGE->set_title($readepub->name);
$PAGE->set_heading($COURSE->fullname);

// Output Moodle page with JS redirect
echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($readepub->name));
echo format_module_intro('readepub', $readepub, $cm->id);

echo html_writer::tag('p', get_string('launchingbook', 'readepub'));
echo html_writer::link($bookurl, get_string('clickherelaunch', 'readepub'), [
    'target' => '_blank',
    'class' => 'btn btn-primary'
]);

// JS auto-launch
echo html_writer::script("
    window.open('{$bookurl->out()}', '_blank');
");

echo $OUTPUT->footer();
