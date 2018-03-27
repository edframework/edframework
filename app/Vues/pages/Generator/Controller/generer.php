<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$json->Generator->genControllerTitle ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <form class="col-12">
                     <div class="form-group row">
                         <label for="libelle" class="col-sm-4 col-form-label"><?=$json->Generator->controllerLib ?></label>
                         <div class="col-sm-8">
                             <input class="form-control" type="text" id="libelle">
                         </div>
                     </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-lg btn-primary col-4 col-md-offset-4" id="generer"><?=$json->Generator->genBtn ?></button>
                        <button type="reset" class="btn btn-lg btn-danger col-4" id="generer"><?=$json->Generator->cancel ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>

    $(document).ready(function () {

        function toast(type, text) {
            $.toast({
                text: text,
                position: 'top-right',
                loaderBg: '#45aef1',
                icon: type,
                hideAfter: 3500,
                stack: 6
            });
        }

       $('#generer').click(function(){
           var libelle = $('#libelle').val();
           if (libelle.length > 0){
               $.ajax({
                   url : "<?=WROOT?>Generator/GController/genAjax",
                   method : "post",
                   dataType : "json",
                   data : {
                       libelle : libelle
                   },
                   success : function(data){
                       if (data == 1){
                           toast('error','Controller '+libelle+' <?=$json->Generator->successGen ?>.');
                       }else if (data ==0){
                           toast('error','Controller '+libelle+' <?=$json->Generator->alreadyExist ?>.');
                       }else if (data == -3){
                           toast('error',"<?=$json->Generator->dberr ?>");
                       }else if (data == -2){
                           toast('error','<?=$json->Generator->missParam ?>.');
                       }
                   }
               });

           }
       });
    });
</script>