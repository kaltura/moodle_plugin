<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  <title>H5P Interactive Video</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

<?php

# Moodle Includes
require_once('../../config.php');
//require_once('locallib.php');

# Globals
global $CFG, $USER, $DB, $PAGE;

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
$PAGE->set_pagelayout('base');
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

<div class="container">
  <div class="card mt-2">
    <div class="card-header text-center">
        <img src="../mymedia/h5p/icon.svg" class="img-thumbnail" alt="...">
      Interactive Video
    </div>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <p class="card-text">Please fill the entry id and click submit button to populate the different video quality that is associated with your video.
   </p>
   <div class="card mb-2 w-50">
     <div class="card-header">
   <h6><i class="fa fa-info-circle p-1"></i>For more information</h6>
  </div>
   <div class="card-body pt-1">
     <p class="card-text">Please visit UR Courses Instuctor guides on <a href="https://urcourses.uregina.ca/guides/instructor/h5p">how to upload a Interactive video in UR Courses</a>.</p>
   </div>
</div>

<form method="post" action="get_h5p_link.php">
<div class="mt-3 mb-2 input-group">
<label for="entryidlabel" class="col-form-label p-2">Entry ID</label>
<input type="text" class="form-control" id="entryidlabel" name="entryId" placeholder="<?php $_POST['entryId'] ?>" value="<?php isset($_POST['entryId']) ? htmlspecialchars($_POST['entryId'], ENT_QUOTES) : '' ?>">
<input name="set" value ="submit" class="btn btn-secondary" type="submit">
</div>

</form>

<?php

if (isset($_POST['entryId'])) {
    $eid = $_POST['entryId']; //pass entry id coming from Input entryId

}

  $client->setKS($ks);
  $filter = new KalturaAssetFilter();
  $pager = new KalturaFilterPager();
  //$pager->pageSize = 500;
  //$pager->pageIndex = 1;

//looks like the script will run right away when the button (URL for H5P) has been clik for the 1st time
//work around add a 0_temp variable for the 1st run to avoid null values error.
 if (empty($eid)) {
   $eid ="0_temp";
 }

  $filter->entryIdEqual = $eid; //entryId being pass to kaltura api call
  $result = $client->flavorAsset->listAction($filter, $pager);

     ?>
<div class="table-responsive">
       <table class="m-auto table table-striped table-hover table-responsive "><tr><th></th><th>Video quality URL</th><th>Format</th><th>Dimension</th><th>Size(kb)</th></tr>


     <?php

     $ta = 0; // var id for the copy flavor url button
   foreach ($result->objects as $entry) { //iterate on the flavor assets objects
          $ta += 1;
          $dimension = $entry->width."X".$entry->height;

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
                  $flavorlink = "Flavor Stuck in convertion Error, Please Notify IT Support";
             }
// display the table
   echo "<tr>
        <td><input data-bs-toggle=\"tooltip\" data-bs-placement=\"left\" title=\"Copy Flavor Url\"
        class=\"btn btn-secondary\" type=\"button\" value=\"Copy URL\" onclick=\"selectElementContents( document.getElementById('$ta') );\" $stat></td>
        <td id='$ta'> ".$flavorlink."</td>
        <td> ".$entry->fileExt."</td>
        <td>".$dimension."</td>
        <td>".$entry->size."</td>
        </tr>";
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
