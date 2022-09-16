<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  <title>H5P Interactive Video</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
</head>

<?php

# Moodle Includes
require_once('../../config.php');
require_once "bootstrap5.php";
//require_once('locallib.php');

# Globals
global $CFG, $USER, $DB, $PAGE, $stat;

$PAGE->set_url('/local/mymedia/get_h5p_link');
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

$PAGE->set_title("H5p Links");
$PAGE->set_pagelayout('report');
$PAGE->set_heading($site->fullname);
$PAGE->navbar->ignore_active();
// using boostrap class

define("PARTNER_ID", "103");
define("ADMIN_SECRET", "5f15c0b27473ecf4b56398db7b48eea9");
define("USER_SECRET",  "f6c308cac9d01e68d8d8ef0d64911793");

require_once "../kaltura/API/KalturaClient.php";

$user = $username;
$kconf = new KalturaConfiguration(PARTNER_ID);
// If you want to use the API against your self-hosted CE,
// go to your KMC and look at Settings -> Integration Settings to find your partner credentials
// and add them above. Then insert the domain name of your CE below.
$kconf->serviceUrl = "https://api.ca.kaltura.com";
$client = new KalturaClient($kconf);
//$ks = $client->session->start($secret, $userId, KalturaSessionType::ADMIN, $partnerId, 86400, 'disableentitlement');

$ks = $client->session->start(ADMIN_SECRET, $user, KalturaSessionType::ADMIN, PARTNER_ID);

if (!isset($ks)) {
  die("Could not establish Kaltura session. Please verify that you are using valid Kaltura partner credentials.");
}
?>

<button type="button" class="btn btn-light backbutton mt-4"  onClick="parent.location='mymedia.php'" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-chevron-left clarete" viewBox="0 0 16 14">
  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
  </svg> BACK TO MY MEDIA </button>

<div class="container-fluid">
  <div class="card mt-2">
    <div class="card-header text-center">
        <img src="../mymedia/h5p/icon.svg" class="img-thumbnail" alt="H5P Icon">
      Interactive Video
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <p class="card-text">Please fill the <strong>Entry ID</strong> and click submit button to populate the different video quality that is associated with your video.
   </p>
   <div class="card mb-2 w-50">
     <div class="card-header">
   <h6><i class="fa fa-info-circle p-1"></i>For more information</h6>
  </div>
   <div class="card-body pt-1">
     <p class="card-text">Please visit UR Courses Instuctor guides on <a href="https://urcourses.uregina.ca/guides/instructor/h5p#creating_an_activity" target="_blank">how to upload a Interactive video in UR Courses</a>.</p>
   </div>
</div>

<form method="post" action="get_h5p_link.php">
<div class="mt-3 mb-2 input-group">
<label for="entryidlabel" class="col-form-label p-2">Entry ID</label>
<input type="text" class="form-control" id="entryidlabel" name="entryId" placeholder="" value="<?php isset($_POST['entryId']) ? htmlspecialchars($_POST['entryId'], ENT_QUOTES) : '' ?>">
<input name="set" value ="submit" class="btn btn-secondary" type="submit">
</div>

</form>

<?php

if (!isset($_POST['entryId'])) {
   $eid ="0_tempvar"; //looks like the script will run right away when the button (URL for H5P) has been clik for the 1st time
   //work around assign temp variable to entryid for the 1st run to avoid null values error coming from Kaltura API.
 } elseif (empty($_POST['entryId'])) { //to cath the kaltura null value error
  $eid ="0_tempvar";//added alert notification instead of null
  ?> 
 <div class="alert alert-primary d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
  <div>
   Nothing to display.
</div>

<?php
 }else {

  $eid = $_POST['entryId']; //pass entry id coming from Input entryId
  $client->setKS($ks);
  $filter = new KalturaAssetFilter();
  $pager = new KalturaFilterPager();

  $filter->entryIdEqual = $eid; //entryId being pass to kaltura api call
  $result = $client->flavorAsset->listAction($filter, $pager);
  if ($result->totalCount == 0) {
    # code...
    ?> 
    <div class="alert alert-info d-flex align-items-center" role="alert">
     <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
     <div>
    Entry ID: <strong><?php echo $eid; ?></strong> is invalid <strong>or</strong> cannot be found in the server.
   </div>
   
   <?php
  }else {



     ?>
<div class="table-responsive">
       <table class="m-auto table table-striped table-hover table-responsive "><tr><th></th><th>Quality</th><th>Video URL</th><th>Format</th><th>Dimension</th><th>Size(kb)</th></tr>


     <?php
    

     $ta = 0; // var id for the copy flavor url button
   foreach ($result->objects as $entry) { //iterate on the flavor assets objects
    //print_r($entry->totalcount);
          $ta += 1;
          $dimension = $entry->width."X".$entry->height;
          if ($entry->flavorParamsId  == 2) {
            $quality = "Basic/Small - WEB/MBL (H264/400)";
            # code...
          }elseif ($entry->flavorParamsId  == 3) {
            $quality = "Basic/Small - WEB/MBL (H264/600)";
            # code...
          }elseif ($entry->flavorParamsId  == 4) {
            $quality = "SD/Small - WEB/MBL (H264/900)";
            # code...
          }elseif ($entry->flavorParamsId  == 5) {
            $quality = "HD/720 - WEB (H264/2500)";
            # code...
          }elseif ($entry->flavorParamsId  == 6) {
            $quality = "SD/Large - WEB/MBL (H264/1500)";
            # code...
          }elseif ($entry->flavorParamsId  == 7) {
            $quality = "HD/1080 - WEB (H264/4000)";
            # code...
          }
          
          //create the flavor url link
          $flavorlink="https://vodcdn.ca.kaltura.com/p/103/sp/10300/serveFlavor/entryId/$eid/v/2/ev/3/flavorId/$entry->id/forceproxy/true/name/a.mp4";

           if ($entry->isOriginal == 1 and $entry->flavorParamsId == 0) {
                 $flavorname = "Source";
                 //$flavorurl = "https://api.ca.kaltura.com/p/103/sp/10300/playManifest/entryId/$eid/format/url/flavorParamIds/0";
                // $flavorlink="https://vodcdn.ca.kaltura.com/p/103/sp/10300/serveFlavor/entryId/$eid/v/2/ev/3/flavorId/$entry->id/forceproxy/true/name/a.mp4";
             }elseif ($entry->status > 2) {
                 // disable entries if status is not equal 2(ready)
                  $flavorlink ="";
                  $entry->fileExt ="";
                  $dimension="";
                  $entry->size="";
                  $stat ="disabled";
             }elseif ($entry->status == 1) {
                  $flavorlink = "Flavor Stuck in conversion Error, Please Notify IT Support";
             }
            if ($entry->flavorParamsId > 0) {
              # code...
           
// display the table
   echo "<tr>
        <td><input data-bs-toggle=\"tooltip\" data-bs-placement=\"left\" title=\"Copy Flavor Url\"
        class=\"btn btn-secondary\" type=\"button\" value=\"Copy URL\" onclick=\"selectElementContents( document.getElementById('$ta') );\" $stat></td>
        <td> ".$quality."
         </td> 
        <td id='$ta'> ".$flavorlink."</td>
        <td> ".$entry->fileExt."</td>
        <td>".$dimension."</td>
        <td>".$entry->size."</td>
        </tr>";
            }
   }
}
?>
</div>
<script type="text/javascript">
// copy the flavor url from the table
function selectElementContents(el) {
       var body = document.body, range, sel;
       if (document.createRange && window.getSelection) {
           range = document.createRange();
           sel = window.getSelection();
           sel.removeAllRanges();
           try {
               range.selectNodeContents(el);
               sel.addRange(range);
           } catch (e) {
               range.selectNode(el);
               sel.addRange(range);
           }
           document.execCommand("copy");
           //alert("copied Flavor Url");
       } else if (body.createTextRange) {
           range = body.createTextRange();
           range.moveToElementText(el);
           range.select();
           range.execCommand("Copy");
       }

       }

</script>

<?php

   }

?>
</div>
</div>
</div>
</html>
