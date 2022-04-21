<?php
require_once('../../config.php');
//require_once('locallib.php');
# Globals
global $CFG, $USER, $DB, $PAGE;

$PAGE->set_url('/local/mymedia/upload');
$PAGE->set_context(context_system::instance());

# Check security - special privileges are required to use this script
$currentcontext = context_system::instance();
$username = $USER->username;
$site = get_site();

list($context, $course, $cm) = get_context_info_array($PAGE->context->id);

require_login($course, true, $cm);

if ( (!isloggedin()) ) {
    print_error("You need to be logged in to access this page.");
    exit;
}

$PAGE->set_title("Import Zoomm Recordings");
$PAGE->set_pagelayout('base');
$PAGE->set_heading($site->fullname);
$PAGE->navbar->ignore_active();


if (isset($_POST['name'])) {

$meeting_id = $_POST['name'];

$curl = curl_init();
$url="https://api.zoom.us/v2/meetings/$meeting_id/recordings/settings";
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PATCH',
    CURLOPT_POSTFIELDS =>'{
      "viewer_download": true,
      "password": ""
  }
  ',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImRhUkFPOUV6UjFxWjFvN2U2N2VkU3ciLCJleHAiOjE2OTk4OTU1MDcsImlhdCI6MTU5OTE0MDEwN30.U4esT6f1c-W-DNun5yah66B3zoap-jOXFXDvveGuEdQ',
      'Content-Type: application/json',
      'Cookie: cred=7A4AC1161FF93912001DD2812965B420'
    ),
  ));

  $response = curl_exec($curl);

curl_close($curl);
echo '<h3>Succesfully Added Request</h3>';
echo "\n Meeting ID: ".$response;
echo $meeting_id;

}
?>
