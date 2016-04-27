<div class="modal fade modal-warning" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style="text-align: left;" class="modal-title" id="myModalLabel"><i class="fa fa-lock"></i> Please Enter Your Password:</h4>
      </div>
	    <form action="violation.php" method="POST">	
	      <div class="modal-body" style="text-align:left;">
	      	<input autofocus required type="password" class="form-control" name="field_password" />
	      </div>
	      <div class="modal-footer">
	        <button type="submit" name="btn_submit" value="<?php echo $_SESSION['student_id']; ?>" class="btn btn-outline">Submit</button>
	        <a href="index.php"><button type="button" class="btn btn-outline">Close</button></a>
	      </div>
	 	</form>
    </div>
  </div>
</div>