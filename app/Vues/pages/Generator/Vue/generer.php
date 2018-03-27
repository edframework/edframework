<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$json->Generator->genViewTitle ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <form class="col-12">
                     <div class="form-group row">
                         <label for="libelle" class="col-sm-4 col-form-label"><?=$json->Generator->viewLib ?></label>
                         <div class="col-sm-8">
                             <input class="form-control" type="text" id="libelle">
                         </div>
                     </div>
                    <div class="checkbox">
                        <input type="checkbox" class="chk-col-blue" id="check1" checked>
                        <label for="check1"><?=$json->Generator->createFolder ?></label>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" class="chk-col-blue" id="check2" checked>
                        <label for="check2">Layout</label>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" class="chk-col-blue" id="check3">
                        <label for="check3"><?=$json->Generator->definePath ?></label>
                    </div>
                    <div class="form-group row directory">
                        <label for="dir" class="col-sm-4 col-form-label"><?=$json->Generator->foldername ?></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="dir" placeholder="<?=$json->Generator->placeholderDefaultPage ?>">
                        </div>
                    </div>
                    <div class="form-group row chemin" style="display: none;">
                        <label for="chemin" class="col-sm-4 col-form-label"><?=$json->Generator->viewPath ?></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="chemin" placeholder="<?=$json->Generator->placeholderDefaultViewPath ?>">
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

        $('#check1').on('change',function () {
            if ($(this).is(':checked') == true){
                $('.directory').show(100);
            }else{
                $('.directory').hide(100);
            }
        });
        $('#check3').on('change',function () {
            if ($(this).is(':checked') == true){
                $('.chemin').show(500);
            }else{
                $('.chemin').hide(500);
            }
        });

        $('#generer').on('click',function (e) {
            e.preventDefault();
            if (validate('libelle',2,20,"","")){
                $.ajax({
                    url : "<?=WROOT?>Generator/GVue/genAjax",
                    dataType : 'json',
                    method : 'post',
                    data : {
                        check1 : $('#check1').is(':checked'),
                        check3 : $('#check3').is(':checked'),
                        check2 : $('#check2').is(':checked'),
                        libelle : $('#libelle').val(),
                        chemin : $('#chemin').val(),
                        nomDirectory : $('#dir').val()
                    },
                    success : function (data) {
                        if (data == 1){
                            toast('success' , "<?=$json->Generator->successView ?>");
                        }else if (data == -3){
                            toast('error' , "<?=$json->Generator->dberr ?>");
                        }else if (data == -2){
                            toast('error' , "<?=$json->Generator->missParam ?>.");
                        }else{
                            toast('error' , "<?=$json->Generator->errGenView ?>")
                        }
                    }
                });
            }

        });
    });
</script>