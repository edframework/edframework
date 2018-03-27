<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$json->Generator->genTableTitle ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <form class="col-12">
                     <div class="form-group row">
                         <label class="col-4"><?=$json->Generator->DB ?></label>
                         <div class="col-8">
                             <select class="form-control select2 database">
                                 <option value=""></option>
                                 <?php foreach ($database as $db) : ?>
                                     <option value="<?=$db?>"><?=$db?></option>
                                 <?php endforeach;?>
                             </select>
                         </div>
                     </div>
                     <div class="form-group row">
                         <label class="col-4">Tables</label>
                         <div class="col-8">
                             <select class="form-control select2 table">
                                 <option value=""></option>
                             </select>
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
        function toast(type , text)
        {
            $.toast({
                text: text,
                position: 'top-right',
                loaderBg: '#45aef1',
                icon: type,
                hideAfter: 3500,
                stack: 6
            });
        }
        $('.select2').select2({
                placeholder: "<?=$json->Generator->chooseElt ?>",
                allowClear: true,
                width : '100%'
            });
        $('.database').on('change',function (e) {
            if ($(this).val().length > 0){
                $.ajax({
                    url : "<?=WROOT?>Generator/GTable/searchTable",
                    method : "post",
                    type : "json",
                    beforeSend : function (xhr) {
                        $('.table').attr('disabled' , 'true');
                    },
                    data : {
                        database : $(this).val()
                    },
                    success : function (data) {
                        let $option = "<option></option>";
                        data = JSON.parse(data);
                        for (let i=0 ; i<data.length ; i++){
                            $option += "<option value='"+data[i].Name+"'>"+data[i].Name+"</option>";
                        }

                        $('.table').html($option);
                        $('.table').removeAttr('disabled');

                    }
                });
            }
        });
        
        $('#generer').on('click' , function (e) {
           e.preventDefault();
            if ($('.database').length == 0){
                toast('error' , "<?=$json->Generator->chooseDB ?>");
            }else if ($('.table').length == 0) {
                toast('error', '<?=$json->Generator->chooseTable ?>');
            } else {
                $.ajax({
                    url: "<?=WROOT?>Generator/GTable/genAjax",
                    method: "post",
                    dataType: "json",
                    data: {
                        database: $('.database').val(),
                        table: $('.table').val()
                    },
                    success: function (data) {
                        if (data == 1){
                            toast('success' , "<?=$json->Generator->successTable ?>")
                        }else if (data == -3){
                            toast('error' , "<?=$json->Generator->dberr ?>");
                        }else if (data == -2){
                            toast('error' , "<?=$json->Generator->missParam ?>.");
                        }else if (data == -4){
                            toast('error' , "<?=$json->Generator->DbOrTableErr ?>.");
                        }else{
                            toast('error' , "<?=$json->Generator->error ?>")
                        }
                    }
                });
            }
        });
    });
</script>