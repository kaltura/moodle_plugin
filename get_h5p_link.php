<?php
// using boostrap class

define("PARTNER_ID", "103");
define("ADMIN_SECRET", "5f15c0b27473ecf4b56398db7b48eea9");
define("USER_SECRET",  "f6c308cac9d01e68d8d8ef0d64911793");

require_once "KalturaClient.php";

$user = "cunnintr";
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
<form method="post" action="getflavorurl.php">
<div class="mt-2 mb-2 input-group">
<label for="entryidlabel" class="col-form-label p-2">Entry ID</label>
<input type="text" class="form-control" id="entryidlabel" name="entryId" placeholder="entryId" value="<?php isset($_POST['entryId']) ? $_POST['entryId'] : '' ?>">
<input name="set" class="btn btn-secondary" type="submit">
</div>
</div>
</form>
</div>
<?php
if (isset($_POST['entryId'])) {
    $eid = $_POST['entryId']; //pass entry id coming from Input entryId

}

  $client->setKS($ks);
  $filter = new KalturaAssetFilter();
  $pager = new KalturaFilterPager();
  $pager->pageSize = 500;
  $pager->pageIndex = 1;

  $filter->entryIdEqual = $eid; //entryId being pass to kaltura api call
  $result = $client->flavorAsset->listAction($filter, $pager);

     ?>
     <div class="container">
     <table id ="" class="table table-striped"><tr><th></th><th>Flavor_URL</th><th>Format</th><th>Dimension</th><th>Size(kb)</th></tr>
     </div>
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
        class=\"btn btn-secondary\" type=\"button\" value=\"Copy Flavor URL\" onclick=\"selectElementContents( document.getElementById('$ta') );\" $stat></td>
        <td id='$ta'> ".$flavorlink."</td>
        <td> ".$entry->fileExt."</td>
        <td>".$dimension."</td>
        <td>".$entry->size."</td>
        </tr>";
?>

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

 //echo "</table>";

?>
