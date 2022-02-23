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
  foreach ($state as  $key => $result) {
          $kconf->format = KalturaClientBase::KALTURA_SERVICE_FORMAT_PHP;
          $entry = new KalturaMediaEntry();
           $uploadURL = $result;
           $titulo = $_POST['title'][$key];

           //echo $titulo;
             if (empty($titulo)) {
               $entry->name = "Zoom recording date: ". $_POST['zoomdate'][$key]."-Uploaded from Zoom URL";

              }else {
                 $entry->name = $titulo;

              }
          $entry->mediaType = KalturaMediaType::VIDEO;
          $results = $kclient->media->addFromUrl($entry, $uploadURL);


?>
  <div  class="card mb-2">
  <div class="card-header">
  Uploaded Entry
  </div>
  <div class="card-body">
    <?php
    $date=date_create();
    date_timestamp_set($date,$results->createdAt);
     echo "<b>Entry ID: </b>".$results->id."<br>";
     echo "<b>Video Title: </b>".$results->name."<br>";
     echo "<b>Download_url: </b>".$results->downloadUrl."<br>";
     echo "<b>Date created: </b>".date_format($date,"Y-M-d H:i:s")."<br>";
     ?>
       </div>
  </div>


<?php

}
}
?>
