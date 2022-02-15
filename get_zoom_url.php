<?php
//include "../../getsettings.php";
require_once('../../config.php');
//require_once('locallib.php');

# Globals
global $CFG, $USER, $DB, $PAGE, $stat, $vmode, $setvmode, $sett, $tigsett;
//$sett='';
$PAGE->set_url('/local/mymedia/upload');
$PAGE->set_context(context_system::instance());

# Check security - special privileges are required to use this script
$currentcontext = context_system::instance();
$username = $USER->username;
$zoomemail = $USER->email;
$lastname = $USER->lastname;
$firstname = $USER->firstname;

$site = get_site();

list($context, $course, $cm) = get_context_info_array($PAGE->context->id);

require_login($course, true, $cm);

if ( (!isloggedin()) ) {
    print_error("You need to be logged in to access this page.");
    exit;
}



 ?>

<!doctype html>
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>

<body>

    <section class="container-fluid mb-2 card">

      <div class="row">
  <div class=" col-md-6 col-lg-6 bg-light">
   <div class="mt-2">
    <h4>
      Upload Zoom
      <small class="text-muted">videos recordings to Kaltura</small>
    </h4>
  </div>
    <p class="text"></p>
    <form method="post" action="get_zoom_url.php">
        <div class="row p-2 form-group">
            <label for="date" class=" col-form-label">From</label>
            <div class="col">
                <div class="input-group date" id="datepickerfrom">
                    <input type="text" name="datefrom" class="form-control">
                    <span class="input-group-append">
                        <span class="input-group-text bg-white d-block">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="row p-2 form-group">
            <label for="date" class=" col-form-label">To</label>
            <div class="col">
                <div class="input-group date" id="datepickerto">
                    <input type="text" name="dateto" class="form-control">
                    <span class="input-group-append">
                        <span class="input-group-text bg-white d-block">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="p-2">
        <input name="set" value ="submit" class="btn btn-secondary" type="submit">
      </div>
    </form>

  <p class="p-2">Please allow all the results to be loaded. </p>
  </div>
  <div class="col-md-6 col-lg-6 bg-light ">
    <div class="mt-2">
    <p>Fill in the dates <b>From</b> and <b>To</b>, to retrieve your zoom recordings.
      This tool will allow you to get all your Zoom recordings base on your date filters.
      </p>
      <p><b>Note:</b> If the Media Title is not filled, the default media title {<strong><?php echo $username; ?>-uploaded from Zooom URL</strong>} will be used.</p>
  </div>
    <div class="card mt-2">
    <div class="card-header">
    <h6><i class="fa fa-info-circle p-1"></i>For more information</h6>
    </div>
    <div class="card-body">
    <p class="card-text">Please visit UR Courses Instuctor guides on <a href="https://urcourses.uregina.ca/guides/instructor/h5p#creating_an_activity" target="_blank">how to import zoom url recordings in Kaltura using mymedia tool</a>.</p>
    </div>
    </div>
  </div>
</div>

    </section>

    <script type="text/javascript">

        $(function() {
            $('#datepickerfrom').datepicker({
              format: 'yyyy-mm-dd'

            });
            $('#datepickerto').datepicker({
              format: 'yyyy-mm-dd'

            });
        });

        $(document).ready(function() {
              $('.spinner-grow').hide();
                $('.spinner-text').hide();
                  $('.uploadurl').hide();
        });
</script>



<!--
<div class="d-flex align-items-center bg-secondary m-3">
  <span class="spinner-text m-2 text-white">Loading results</span>
<div class="spinner-grow spinner-grow-sm text-light m-1" role="status" id="spinner">
 <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-grow text-light spinner-grow-sm m-1" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
<div class="spinner-grow text-light spinner-grow-sm m-1" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
</div> -->

<?php


if (empty($_POST['datefrom'])) {
  // code...
  $stat ="disabled";
}
if (isset($_POST['datefrom']) && isset($_POST['dateto'])) {

  $start    = new DateTime($_POST['datefrom']);
  $end      = new DateTime($_POST['dateto']);
  $interval = DateInterval::createFromDateString('1 month');
  $period   = new DatePeriod($start, $interval, $end);

foreach ($period as $dateval) {

  $xdate = $dateval->format("Y-m-d");

    $curl = curl_init();
    $url ="https://api.zoom.us/v2/users/$zoomemail/recordings?page_size=30&mc=false&trash=false&from=".$_POST['datefrom']."&to=".$xdate;
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImRhUkFPOUV6UjFxWjFvN2U2N2VkU3ciLCJleHAiOjE2OTk4OTU1MDcsImlhdCI6MTU5OTE0MDEwN30.U4esT6f1c-W-DNun5yah66B3zoap-jOXFXDvveGuEdQ',
        'Cookie: cred=31C801287EBEB8624CE52AB7A29404EC'
      ),
    ));
$response = json_decode(curl_exec($curl));
$resulta = array_values($response->meetings);

?>

  <div class="container-fluid">

  <?php
foreach ($resulta as  $records) {

  foreach (array_values($records->recording_files) as  $recfiletype) {
    $tigsett = $recfiletype->meeting_id;
  }


?>

<div class="card mb-4">
  <div class="card-header text-white bg-secondary p-3">
   <form>
   <input type="hidden" name="form" value="A">
    <button name="enable" id="send" value ="<?php echo $recfiletype->meeting_id; ?>" class="btn btn-light enablevmode float-end" type="submit" >Allow upload to Kaltura</button>
    <input type="hidden" name="name"  value="<?php echo $recfiletype->meeting_id; ?>">
   </form>
  <?php

   echo "<strong>Meeting Topic: </strong>".$records->topic ."<br>";
   echo "<strong>Date: </strong>".$records->start_time;
   ?>
</div>
  <form  method="post" id="uploadfrm">
<?php
foreach (array_values($records->recording_files) as  $recfiles) {

        $sett = $recfiles->meeting_id;
        $curl = curl_init();
        $url ="https://api.zoom.us/v2/meetings/$sett/recordings/settings";
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6ImRhUkFPOUV6UjFxWjFvN2U2N2VkU3ciLCJleHAiOjE2OTk4OTU1MDcsImlhdCI6MTU5OTE0MDEwN30.U4esT6f1c-W-DNun5yah66B3zoap-jOXFXDvveGuEdQ',
            'Cookie: cred=4E75F9DFC231F95504A761C70C977CC4'
          ),
        ));

        $json =curl_exec($curl);

        $json_response = json_decode($json, true);

         if ($json_response['viewer_download']==0) {
           $setvmode ="disabled";
         }else {
             // code...
             $setvmode ="";
           }

    ?>

      <div class="card-body">
        <fieldset class="uploadfrm5">
              <div class="form-floating mb-3 tit1">
                <input type="text" name="title" class="form-control tit" id="floatingInput" placeholder="Media Title">
                <label for="floatingInput">Media Title</label>
              </div>
              <div class="form-check m-2">
                <input class="form-check-input" name="chooser[]" type="checkbox" value="<?php echo $recfiles->download_url; ?>" id="flexCheckDefault" <?php echo $setvmode; ?>>
                  <label class="form-check-label" for="flexCheckDefault">
                      <?php
                      echo "<p class=\"card-text\">".$recfiles->download_url."</p>";
                      ?>
                  </label>
            </div>
            <div class="">
            <p class="card-text bg-light">
            <strong>Recording type:</strong>
            <?php
            echo $recfiles->recording_type;
            ?>
            </p>
          </div>
        </fieldset>
        </div>

        <script>
        $(document).ready(function() {
                 $('.uploadurl').show();
        });
        </script>
<?php


}
?>

<div class="card-footer text-white bg-secondary">

</div>
</div>

<?php
}
?>
</div>
<?php

curl_close($curl);
}
} else {

}

?>

<div class="container-fluid">
<input form="uploadfrm" type="submit" class="btn btn-secondary uploadurl" name="upload" value="Upload to kaltura" <?php echo $stat; ?>>
  </form>
</div>

<script type="text/javascript">
$(document).ready(function () {
$('.uploadurl').click(function (e) {

var list =[]
var title =[]

 $("[name='chooser[]']:checked").each(function () {
               var current =  $(this).val();
              title.push($(this).parents("fieldset").find(".tit").val())
               list.push(current)

});

  $.ajax({
    type: 'post',
    url: 'upload.php',
    datatype: 'jason',
    data:{'chooser': list, 'title': title},
    //processData:false,
     success: function (response) {
       alert(response);
           //$("#results").html(response);

        }
  });

e.preventDefault();

});
});

</script>
<script type="text/javascript">
$(document).ready(function () {
$('.enablevmode').click(function (e) {

    var origData = $(this).val();
    var formData1 = origData.replace(/name=/,"");
    var formData2 = formData1.replace(/%2B/,"+");
    //alert(origData);
    var formData = formData1.replace(/%3D%3D/,"==");
  $.ajax({
    type: 'post',
    url: 'enabledownload.php',
    data: {'name':formData},
     success: function (data) {
          alert(data);
        }
  });

e.preventDefault();

});
});

</script>
</body>

</html>
