<div class="webcam">
	<script language="JavaScript">
		webcam.set_api_url( 'capture.php' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound

		document.write( webcam.get_html(320, 240) );
	</script>
	<br />
	<button type="button" class="btn btn-default capture" onClick="webcam.freeze()">Capture</button>
	<button type="button" class="btn btn-default upload" onClick="do_upload()">Upload</button>
	<button type="button" class="btn btn-default reset" onClick="webcam.reset()">Reset</button>
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );
		
		function do_upload() {
			// upload to server
			webcam.upload();
		}
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			if (msg.match(/(http\:\/\/\S+)/)) {
				var image_url = RegExp.$1;
				// show JPEG image in page
				document.getElementById('upload_results').innerHTML = 
					'<img src="' + image_url + '"class="img-thumbnail">';
				// reset camera for another shot
				webcam.reset();
			}
			else alert("PHP Error: " + msg);
		}
	</script>
</div>
<div id="upload_results"></div>