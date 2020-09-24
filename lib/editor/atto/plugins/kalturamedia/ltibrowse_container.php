<?php

require(__DIR__.'/../../../../../config.php');
require_login();

global $PAGE;

$queryparams = [
    'elementid' => optional_param('elementid', '', PARAM_TEXT),
    'contextid' => optional_param('contextid', 0, PARAM_INT),
    'height' => optional_param('height', '', PARAM_TEXT),
    'width' => optional_param('width', '', PARAM_TEXT)
];

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('embedded');
$PAGE->set_url(
        '/lib/editor/atto/plugins/kalturamedia/ltibrowse_container.php',
        $queryparams
);

$ltibrowseUrl = new moodle_url('/lib/editor/atto/plugins/kalturamedia/ltibrowse.php', $queryparams);

/** @var core_renderer $OUTPUT */
$OUTPUT;

echo $OUTPUT->header();
?>

<iframe allow="autoplay *; fullscreen *; encrypted-media *; camera *; microphone *;"
        id="kafIframe" src="<?php echo $ltibrowseUrl->out(); ?>"
        width="100%" height="600" style="border: 0;" allowfullscreen>
</iframe>
<script>
    var buttonJs = window.opener.buttonJs;

    function kaltura_atto_embed(data) {
        buttonJs.embedItem(buttonJs, data);
    }
</script>

<?php
echo $OUTPUT->footer();