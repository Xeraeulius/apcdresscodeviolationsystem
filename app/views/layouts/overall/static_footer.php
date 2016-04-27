	  	</div>
	</div>
<script>
$(document).ready(function(){
    // Show the Modal on load
    $("#myModal").modal({backdrop: "static"});
    
    // Hide the Modal
    $("#myBtn").click(function(){
        $("#myModal").modal("hide");
    });
});

$(document).ready(function(){
    // Show the Modal on load
    $("#loginModal").modal({backdrop: "static"});
    
    // Hide the Modal
    $("#loginBtn").click(function(){
        $("#loginModal").modal("hide");
    });
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="app/assets/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>