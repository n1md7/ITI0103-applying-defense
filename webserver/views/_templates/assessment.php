<?php $lab = require('./questions.php'); ?>
<!-- Full Height Modal Right -->
<div class="modal fade left" id="labInfoBtn" tabindex="-1" role="dialog" aria-labelledby="labInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-full-height modal-left modal-md" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="labInfoLabel">Lab info</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab"
              aria-controls="pills-description" aria-selected="true">Description</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-flag-tab" data-toggle="pill" href="#pills-flag" role="tab"
              aria-controls="pills-flag" aria-selected="false">Flag submission</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-hint-tab" data-toggle="pill" href="#pills-hint" role="tab"
              aria-controls="pills-hint" aria-selected="false">Hints</a>
          </li>
        </ul>
        <div class="tab-content pt-2 pl-1" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
            <h5>Task Description</h5>
            <p class="blue-grey-text"><?php echo $lab['description']; ?></p>
          </div>
          <div class="tab-pane fade" id="pills-flag" role="tabpanel" aria-labelledby="pills-flag-tab">
            <?php foreach ($lab['questions'] as $key => $question): ?>
              <section class="tasks mb-5">
                <form method="post" action="<?php echo ASSESMENT; ?>" class="w-100 mx-0">
                  <input type="hidden" name="action" value="check">
                  <input type="hidden" class="csrf" name="csrf">
                  <input type="hidden" name="task" value="<?php echo $key; ?>">
                  <div class="row">
                    <div class="col col-12 q-area">
                      <p class="grey-text"><?php echo $question; ?></p>
                      <div class="alert alert-danger fade show" role="alert" style="display: none;">
                        <strong>Error!</strong> This answer is wrong.
                      </div>
                      <div class="alert alert-success fade show" role="alert" style="display: none;">
                        <strong>Success!</strong> You found it.
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-8 pr-0">
                      <input type="text" name="answer" required="" autocomplete="off" class="form-control" placeholder="Answer here...">
                    </div>
                    <div class="col-4 pl-1">
                      <button type="submit" class="btn btn-success m-0 w-100 font-weight-bold">Validate</button>
                    </div>
                  </div>
                </form>
              </section>
            <?php endforeach; ?>
          </div>
          <div class="tab-pane fade" id="pills-hint" role="tabpanel" aria-labelledby="pills-hint-tab">
            <h5>Hints</h5>
            <?php foreach ($lab['hints'] as $key => $hint): ?>
              <p class="mb-2 blue-grey-text text-small"><?php echo '#'.($key+1).'. '.$hint; ?></p>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Full Height Modal Right -->

<script type="text/javascript">
  $('.tasks').each(function(){
     $(this).find('form').submit(function(event){
      $form = $(this);
      $.ajax({
          beforeSend: function(){
              $form.find('.btn').attr('disabled', '');
              $form.find('.alert').hide();
              $form.find('button[type=submit]').html('...');
          },
          method: 'POST',
          data: $form.serialize(),
          url: $form.attr('action'),
          success: function(data){
              $('.csrf').val(data.csrf);
              if(typeof data.status !== "undefined"){
                if(typeof data.msg !== "undefined" && data.msg === 'correct'){
                  $form.find('.alert.alert-success').show();
                }else{
                  $form.find('.alert.alert-danger').show();
                }
              }
          },
          error: function(){
              console.warn('No Interent!');
          },
          complete: function(){
            $form.find('button[type=submit]').html('Validate');
            $form.find('.btn').removeAttr('disabled');
          }
      });

      event.preventDefault();
      return false;
    });
  });


  $('#labInfoBtn').on('show.bs.modal', function (e) {
    $.ajax({
      method: 'POST',
      data: {
        csrf: $('meta[name=csrf]').attr('content'),
        action: 'highlight'
      },
      url: '<?php echo ASSESMENT; ?>',
      success: function(res){
          $('meta[name=csrf]').attr('content', res.csrf);
          if(typeof res.status !== "undefined"){
            if(typeof res.data !== "undefined"){
              $('.tasks').each(function(i){
                if(res.data.filter(x => x.task_number*1 === i+1).length !== 0){
                  $(this).find('.q-area').find('.alert-info').remove();
                  $(this).find('.q-area').append(`
                    <div class="alert alert-info fade show" role="alert">
                      Marked as <b>done</b>.
                    </div>
                  `);
                }
              })
            }
          }
      },
      error: function(){
          console.warn('No Interent!');
      }
    });
  });

</script>