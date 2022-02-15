
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>

<body>

<?php
require_once('../../config.php');
//require_once('locallib.php');
# Globals
global $CFG, $USER, $DB, $PAGE, $sett;

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

define("PARTNER_ID", "103");
define("ADMIN_SECRET", "5f15c0b27473ecf4b56398db7b48eea9");
define("USER_SECRET",  "d8027e262988b996b7ed8b3eacc23295");

require_once "../kaltura/API/KalturaClient.php";

$user = $username;  // If this user does not exist in your KMC, then it will be created.
$kconf = new KalturaConfiguration(PARTNER_ID);
// If you want to use the API against your self-hosted CE,
// go to your KMC and look at Settings -> Integration Settings to find your partner credentials
// and add them above. Then insert the domain name of your CE below.
// $kconf->serviceUrl = "http://www.mySelfHostedCEsite.com/";
$kconf->serviceUrl = "https://api.ca.kaltura.com";
$kclient = new KalturaClient($kconf);
$ksession = $kclient->session->start(ADMIN_SECRET, $user, KalturaSessionType::ADMIN, PARTNER_ID, null, 'disableentitlement');

if (!isset($ksession)) {
  die("Could not establish Kaltura session. Please verify that you are using valid Kaltura partner credentials.");
}
$kclient->setKs($ksession);


if (isset($_POST['chooser'])) {

  $state = $_POST['chooser'];
  $title = array_values($_POST['title']);
  foreach ($title as $key => $sett) {
    // code...
  }
  foreach ($state as $key => $result) {

          $kconf->format = KalturaClientBase::KALTURA_SERVICE_FORMAT_PHP;
          $entry = new KalturaMediaEntry();
           $uploadURL = $result;
            if (!empty($title[$key])) {
               $entry->name = $title[$key];

            } else {
              $entry->name = $username."-uploaded from Zoom URL";
            }

          $entry->mediaType = KalturaMediaType::VIDEO;
          $result1 = $kclient->media->addFromUrl($entry, $uploadURL);

  }
  ?>
  <div class="container">
    <div class="card">
      <div class="" id="#results">
        <h4> Uploaded Entry </h4>
        <?php
        print_r($state);
        ?>
      </div>
    </div>
  </div>
  <php>
//print_r($state);

//print_r($title);
<?php
   }

?>
</body>
</html>
