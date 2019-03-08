<div class="row justify-content-center animated flipInX mb-4">
    <div class="col-md-6">
        <div class="form-group mb-5">
            <h3 class="text-center text-info">Search movies <i class="fa fa-film"></i></h3>
            <h3 class="text-center spinner" style="display: none;">
                <i class="fa fa-spinner fa-spin fa-2x fa-fw text-info"></i>
           </h3>
        </div>
        <div class="form-group md-form">
            <form action="" method="post" id="searchForm" data-action="<?php echo HOME_AJAX;?>">
                <input name="search" type="search" id="text" class="form-control" aria-describedby="searchBoxtext" autocomplete="off" autofocus="on" spellcheck="false">
                <label for="text" class="label-placeholder">Search here... ex. Harry Potter and hit <kbd>ENTER</kbd></label>
                <small id="searchBoxtext" class="form-text text-muted">
                    Search keyword must contain only [ <kbd class="text-info" style="background: #ababab;">abcdefghijklmnopqrstuvwxyz</kbd> ] symbols
                </small>

                <input type="hidden" class="csrf" name="csrf" value="">
                <input type="hidden" name="action" value="search">
            </form>
        </div>
    </div>
</div>
<div class="row justify-content-center animated flipInX innerText"></div>
<script>
    $('.nav-item.home').addClass('active');
    $('#searchForm').submit(function(event){
        $(this).find('input[name=csrf]').val($('meta[name=csrf]').attr('content'));

        $.ajax({
            beforeSend: function(){
                $('.alert').alert('close');
                $('.spinner').show();
                $('.innerText').html('');
            },
            method: 'POST',
            data: $('#searchForm').serialize(),
            url: $('#searchForm').data('action'),
            success: function(data){
                $('.spinner').hide();
                $('meta[name=csrf]').attr('content', data.csrf);
                if(typeof data.status !== "undefined" && data.status === 'success'){
                        let html = "";
                        data.data.forEach(function(ebook){

	                        html += `
	                            <div class="animated flipInY card m-2" style="width: 18rem;">
	                              <img class="card-img-top" src="<?php echo ROOT_PATH; ?>assets/img/${ebook.img}" alt="${ebook.img}">
	                              <div class="card-body">
	                                <h5 class="card-title">${ebook.title}</h5>
	                                <p class="card-text">${ebook.description}</p>
	                              </div>
	                            </div>
	                            `;
                        });
                    $('.innerText').html(html);

                        if(data.data.length === 0){
                            $('.innerText').html(`<div class="animated flipInX col-md-6"><h3 class="text-center text-danger">No data to output</h3></div>`);
                        }
                }else{
                    $('.innerText').html(`<div class="animated flipInX col-md-6"><h3 class="text-center">No data to output</h3></div>`);
                }

            },
            error: function(){
                $('.innerText').prepend(`
                    <div class="animated flipInX col-md-6">
                        <h3 class="text-center">Something went wrong!</h3>
                    </div>                 
                `); 
                $('.spinner').hide();
            },
            complete: function(){
                $('labef[for=text]').addClass('active');
                $('#text').trigger('focus');
            }
        });

        event.preventDefault();
    });


</script>