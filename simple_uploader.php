<?php


# Moodle Includes
require_once('../../config.php');
//require_once('locallib.php');

# Globals
global $CFG, $USER, $DB, $PAGE;

$PAGE->set_url('/local/mymedia/simple_uploader');
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

$PAGE->set_title("simple uploader");
$PAGE->set_pagelayout('base');
$PAGE->set_heading($site->fullname);
$PAGE->navbar->ignore_active();


// Upload a file to the KMC

// Your Kaltura partner credentials
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
$ksession = $kclient->session->start(ADMIN_SECRET, $user, KalturaSessionType::ADMIN, PARTNER_ID);

if (!isset($ksession)) {
	die("Could not establish Kaltura session. Please verify that you are using valid Kaltura partner credentials.");
}

$kclient->setKs($ksession);


/*
// Set the response format
// KALTURA_SERVICE_FORMAT_JSON  json
// KALTURA_SERVICE_FORMAT_XML   xml
// KALTURA_SERVICE_FORMAT_PHP   php
$kconf->format = KalturaClientBase::KALTURA_SERVICE_FORMAT_PHP;

$movie = "flow_in_the_sky.mp4";

$token = $kclient->media->upload($movie);

$entry = new KalturaMediaEntry();

$entry->name = "Flower in the sky - apr 18";
$entry->mediaType = KalturaMediaType::VIDEO;

$result = $kclient->media->addFromUploadedFile($entry, $token);

echo '<h3>Media entry structure returned</h3>';
echo '<pre>';
print_r($result);
echo '</pre>';
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Alternate Upload to Kaltura</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="simple/style.css" />
    <link rel="stylesheet" href="simple/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="simple/resumable.js"></script>
  </head>
  <body class="page">
    
	  <p class="mt-1"><a href="javascript:window.history.back()" class="btn btn-primary" style="float: right">Back to My Media</a></p>
      <div class="content">
    <div id="frame">

      <fieldset>
	  	  
      <h3>Upload to My Media</h3>
      
	  <p>This alternate uploader is intended to improve performance for users with upload speeds less than 8 mbps.</p>
	  <p>If you continue to experience problems uploading media, please contact <a href="mailto:it.support@uregina.ca">it.support@uregina.ca</a>.</p>
	  
      <script >
          function setInputValue(id, value) {
              document.getElementById(id).value=value;
          }
          function getInputValue(id) {
              return document.getElementById(id).value;
          }
          var VERY_BIG_CHUNK = Math.pow(2,100);
      </script>

      <div class="resumable-error">
        <p>Your browser, unfortunately, is not supported by Resumable.js. The library requires support for <a href="http://www.w3.org/TR/FileAPI/">the HTML5 File API</a> along with <a href="http://www.w3.org/TR/FileAPI/#normalization-of-params">file slicing</a>.</p>
      </div>

	  <div class="row">
	  <div class="col-sm-8">
	  <div class="form-group valid-row mb-5">
	      <div class="resumable-drop" ondragenter="jQuery(this).addClass('resumable-dragover');" ondragend="jQuery(this).removeClass('resumable-dragover');" ondrop="jQuery(this).removeClass('resumable-dragover');">
	        Drop video files here to upload or <a class="resumable-browse"><u>select from your computer</u></a>
	      </div>

	      <div class="resumable-progress">
	        <table>
	          <tr>
	            <td width="100%"><div class="progress-container"><div class="progress-bar"></div></div></td>
	            <td class="progress-text" nowrap="nowrap"></td>
	            <td class="progress-pause" nowrap="nowrap">
	              <a href="#" onclick="r.upload(); return(false);" class="progress-resume-link"><img src="simple/resume.png" title="Resume upload" /></a>
	              <a href="#" onclick="r.pause(); return(false);" class="progress-pause-link"><img src="simple/pause.png" title="Pause upload" /></a>
	              <a href="#" onclick="r.cancel(); return(false);" class="progress-cancel-link"><img src="simple/cancel.png" title="Cancel upload" /></a>
	            </td>
	          </tr>
	        </table>
	      </div>
      
	      <div id="report" style="color: rgb(0, 111, 255);"></div>

	      <ul class="resumable-list"></ul>
	  </div>
	  <div class="form-group valid-row">
	    <label for="inputSimUploads">Simultaneous uploads:</label>
	    <input id="inputSimUploads" type="text" value="5"> 
	  </div>
	  <div class="form-group valid-row">
	    <label for="inputChunkSize">Chunk size (kb):</label>
	    <select id="inputChunkSize" name="inputChunkSize" class="form-control select">
		<option value="Unchunked">Unchunked</option>
		<option value="256">256</option>
		<option value="512">512</option>
		<option value="1024" selected="selected">1024</option>
		<option value="2048">2048</option>
		<option value="4096">4096</option>
		<option value="10240">10240</option>
		
	    </select>
	  </div>
	  <div class="form-group valid-row">
	    <p class="text-muted">Kaltura Service URL: <?php echo $kconf->serviceUrl ?><br />
		Partner ID: <?php echo PARTNER_ID ?><br />
		User: <?php echo $user ?><br />
		KS: <?php echo $ksession ?></p>
	    <input class="form-control" id="serviceUrl" type="hidden" value="<?php echo $kconf->serviceUrl ?>" size="30">
	    <input class="form-control" id="userId" type="hidden" size="30" value="<?php echo $user ?>">
	    <input class="form-control" id="partnerId" type="hidden" size="30" value="<?php echo PARTNER_ID ?>">
	    <input class="form-control" id="inputKS" type="hidden" size="30" value="<?php echo $ksession ?>">
	  </div>
	  </div>
	  </div>
	  </fieldset>
      
      
      </div>
	  </div>

      <script>
        var kalturaSessionKey = null;
	var kalturaPartnerId = null;
	var kalturaUserId = null;
        var kalturaServerBase = null; 
	var uploadToken = new Array();
        var lastUploadToken = null;
	// if you wish to report the stats to an SQLITE DB, set this to where you host process_upload_stats.php
        // you also need to create the SQLITE DB from the chunked_upload.sql schema and ensure the web server user has write permissions to it and the directory in which it resides	
	var statsReportingEndpoint = null;

        function genKS(server,userId, password, partnerId)
        {
            var params;
            if (partnerId){
                params="loginId="+encodeURIComponent(userId)+"&password="+encodeURIComponent(password)+"&partnerId="+encodeURIComponent(partnerId);
            }else{
                params="loginId="+encodeURIComponent(userId)+"&password="+encodeURIComponent(password);
            }
            kDoJSONRequest(server, null, "/service/user/action/loginByLoginId", 
                params, function(ks) {
                    if (ks.code && ks.message){
                        document.getElementById("inputKS").value='error generating KS '+ ks.message;
                        return false;
                    }else{
                        document.getElementById("inputKS").value=ks;
                    }
            });
        }   
       
        function kDoJSONRequest(server, ks, path, queryString, callback) {
            
	    if (ks){
		var url = server + path + "?clientTag=kaltura-parallel-upload-resumablejs&format=1&ks=" + ks + "&" + queryString;
	    }else{
		var url = server + path + "?clientTag=kaltura-parallel-upload-resumablejs&format=1&" + queryString;
	    }
            
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.responseType = "json";
            xhr.onload = function(event) {
                callback(event.target.response);
            };
            xhr.send();
        }
        
        function analyticsRequest(endpoint, query) {
            //do something with the upload stats for QoS
            
            var params = [];
            for (var key in query) {
                if (query.hasOwnProperty(key)) {
                    var value = query[key];
                    params.push(key + "=" + encodeURIComponent(value));
                }
            }
            params = params.join('&');
            url = endpoint + "?" + params;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.send();
        }

        function kAddUploadToNewMedia(server, ks, uploadToken, name, report) {
            
            kDoJSONRequest(server, ks, "/service/media/action/addFromUploadedFile", 
                "mediaEntry:name=" + encodeURIComponent(name) + "&mediaEntry:mediaType=1" +
                "&uploadTokenId=" + uploadToken, function(response) {
		var kalturaEntryId=null;
		var reportDiv = document.getElementById("report");
		if (response.id){
			kalturaEntryId=response.id;
			reportDiv.style.color="rgb(0, 111, 255)";
			status_msg ="Last fully uploaded entry ID: <b>"+response.id + "</b>, Entry Name: <b>"+response.name+"</b>"; 
			report['entry_id']=kalturaEntryId;
			is_success = true;
		}else{
			reportDiv.style.color="red";
			status_msg ='Upload ERROR! Code: ' + response.code + 'Message: ' + response.message;
			is_success = false;
		}

		console.log('entry ID is '+kalturaEntryId);
		reportDiv.innerHTML=status_msg;
		report['last_status']=status_msg;
		// Reflect that the file upload has completed
		if (statsReportingEndpoint){
			analyticsRequest(statsReportingEndpoint,report);
		}
		return is_success;
            });
        }
        


        function kUpload(server, ks, fileName, fileUniqueIdentifier, fileSize, resumable, report) {
            resumable.opts.target = server + "/service/uploadToken/action/upload";
            resumable.opts.fileParameterName = "fileData";
            
            
            kDoJSONRequest(server, ks, "/service/uploadToken/action/add",
                "uploadToken:objectType=KalturaUploadToken" +
                "&uploadToken:fileName=" + encodeURIComponent(fileName) +
                "&uploadToken:fileSize=" + fileSize, function(response) {
		    if (!response.id){
			var reportDiv = document.getElementById("report");
			reportDiv.style.color="red";
			status_msg='Upload ERROR! Code: ' + response.code + '</br>Message: ' + response.message;
			$(reportDiv).html(status_msg);
			$('.resumable-file-progress').html('FAILED');
			report['last_status']=status_msg;
			if (statsReportingEndpoint){
				analyticsRequest(statsReportingEndpoint,report);
			}
			return false;
		    }
                    
		    if (! uploadToken[fileUniqueIdentifier]){
			uploadToken[fileUniqueIdentifier] = response.id;
		    }
                    var query = function(file, chunk) {
                        var params = {
                            format: 1,
                            ks: ks,
                            uploadTokenId: uploadToken[file.uniqueIdentifier],
                            resume: chunk.offset > 0 ? 1 : 0,
                            resumeAt: chunk.startByte,
                            finalChunk: chunk.offset+1 == file.chunks.length ? 1 : 0,
                        };
                        console.log("uploadToken.upload(): ", params);
                        return params;
                    };
                    resumable.opts.query = query;
                    resumable.upload();
                    
            });
        }
        
        var lastUploadStartTime = null;

        var r = new Resumable({
            chunkSize:1*1024*1024,
            simultaneousUploads:5,
            testChunks:false,
            throttleProgressCallbacks:1,
        });
        // Resumable.js isn't supported, fall back on a different method
        if(!r.support) {
          $('.resumable-error').show();
        } else {
          // Show a place for dropping/selecting files
          $('.resumable-drop').show();
          r.assignDrop($('.resumable-drop')[0]);
          r.assignBrowse($('.resumable-browse')[0]);

          // Handle file add event
          r.on('fileAdded', function(file){
              var chunkSize = parseFloat(getInputValue("inputChunkSize"));
              if (chunkSize === -1) {
                  chunkSize = VERY_BIG_CHUNK;
              }
                r.opts.chunkSize = chunkSize*1024;
                r.opts.simultaneousUploads = parseInt(getInputValue("inputSimUploads"));
                file.bootstrap();
                kalturaSessionKey = getInputValue("inputKS");
		kalturaServerBase = getInputValue("serviceUrl")+"/api_v3";
		kDoJSONRequest(kalturaServerBase, kalturaSessionKey, "/service/user/action/get", null,function(response) {
			if (!response.partnerId){
			    console.log('error when calling user.get()' + response.code + ' ' + response.message);
			    return false;
			}
			kalturaPartnerId=response.partnerId;
			kalturaUserId=response.id;
		});

              // Show progress pabr
              $('.resumable-progress, .resumable-list').show();
              // Show pause, hide resume
              $('.resumable-progress .progress-resume-link').hide();
              $('.resumable-progress .progress-pause-link').show();
              // Add the file to the list
              $('.resumable-list').append('<li class="resumable-file-'+file.uniqueIdentifier+'">Uploading <span class="resumable-file-name"></span> <span class="resumable-file-progress"></span>');
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-name').html(file.fileName);
              // add upload to new media
              var report = {
                  user_id: kalturaUserId, 
                  token_id: uploadToken[file.uniqueIdentifier], 
                  partner_id: kalturaPartnerId, 
                  concurrent_chunks: r.opts.simultaneousUploads,
                  chunk_size: r.opts.chunkSize,
                  file_size: file.size,
                  filename: file.fileName, 
              };
              // Actually start the upload
                kUpload(kalturaServerBase, kalturaSessionKey, file.fileName, file.uniqueIdentifier, file.size, r, report);
            });
          r.on('pause', function(){
              // Show resume, hide pause
              $('.resumable-progress .progress-resume-link').show();
              $('.resumable-progress .progress-pause-link').hide();
            });
          r.on('complete', function(){
              // Hide pause/resume when the upload has completed
              $('.resumable-progress .progress-resume-link, .resumable-progress .progress-pause-link').hide();
            });
          r.on('fileSuccess', function(file,message){
              var duration = (Date.now() - lastUploadStartTime)/1000;
              var mbSize = file.size/1024/1024;
              var speed = mbSize/duration;
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-progress').html('completed! File size: ' + mbSize.toFixed(3) + 'MB , Upload duration: ' + duration.toFixed(1) + ' secs, Speed: '+ speed.toFixed(1)+ ' mb/s');
	      

              
              // add upload to new media
              var report = {
                  user_id: kalturaUserId, 
                  token_id: uploadToken[file.uniqueIdentifier], 
                  partner_id: kalturaPartnerId, 
		  upload_total_time: duration,
                  concurrent_chunks: r.opts.simultaneousUploads,
                  total_chunks: file.chunks.length,
                  chunk_size: r.opts.chunkSize,
                  file_size: file.size,
                  filename: file.fileName, 
              };
              kAddUploadToNewMedia(kalturaServerBase, kalturaSessionKey, uploadToken[file.uniqueIdentifier], file.uniqueIdentifier, report);
              
            });
          r.on('fileError', function(file, message){
              // Reflect that the file upload has resulted in error
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-progress').html('(file could not be uploaded: '+message+')');
            });
          r.on('fileProgress', function(file){
              // Handle progress for both the file and the overall upload
              $('.resumable-file-'+file.uniqueIdentifier+' .resumable-file-progress').html(Math.floor(file.progress()*100) + '%');
              $('.progress-bar').css({width:Math.floor(r.progress()*100) + '%'});
            });
          r.on('cancel', function(){
            $('.resumable-file-progress').html('canceled');
          });
          r.on('uploadStart', function(){
              lastUploadStartTime = Date.now();
              // Show pause, hide resume
              $('.resumable-progress .progress-resume-link').hide();
              $('.resumable-progress .progress-pause-link').show();
          });
        }
      </script>

    </div>
    <!--footer id="footer">
	<div class="f1">
	    <div class="content">
		<p>This page is used to test and analyze global Kaltura upload over parallel chunks across browsers.</p>
		<p>When you upload a file we collect data that will help QA and improve the upload experience. No personal user data or sensitive data is collected.</p>
	    </div>
	</div>
    </footer-->

  </body>
</html>
