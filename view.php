<?php

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');

$id = required_param('id', PARAM_INT); // Course module ID

$cm = get_coursemodule_from_id('readepub', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$context = context_module::instance($cm->id);

require_login($course, true, $cm);
require_capability('mod/readepub:view', $context);

$readepub = $DB->get_record('readepub', ['id' => $cm->instance], '*', MUST_EXIST);

// Build the URL to launch
$bookurl = new moodle_url('/mod/readepub/bibi/index.php', [
    'book' => $readepub->bookname,
    'cmid' => $cm->id
]);

$PAGE->set_url('/mod/readepub/view.php', ['id' => $cm->id]);
$PAGE->set_context($context);
$PAGE->set_title(format_string($readepub->name));
$PAGE->set_heading(format_string($course->fullname));

// Completion tracking
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($readepub->name));
echo format_module_intro('readepub', $readepub, $cm->id);

echo html_writer::tag('p', get_string('launchingbook', 'mod_readepub'));

echo html_writer::link(
    $bookurl,
    get_string('clickherelaunch', 'mod_readepub'),
    [
        'target' => '_blank',
        'class' => 'btn btn-primary'
    ]
);

// Safe JS auto-launch
$PAGE->requires->js_init_code("
    window.open(" . json_encode($bookurl->out()) . ", '_blank');
");

echo $OUTPUT->footer();
