<div class="modal fade modal-warning" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style="text-align: left;" class="modal-title" id="myModalLabel"><i class="fa fa-info"></i> Notice from the Disciplinary Officer</h4>
      </div>
      <div class="modal-body" style="text-align:left;">
        <i class="fa fa-warning"></i> You have <?php echo number_of_notifications($search_id); echo number_of_notifications($search_id) > 1 ? " messages" : " message"; ?> that needs to be reviewed upon on.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>