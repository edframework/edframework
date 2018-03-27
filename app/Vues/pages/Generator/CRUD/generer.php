<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$json->Generator->genCRUDTitle ?></h3>
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
                                    <option value="<?= $db ?>"><?= $db ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4">Table</label>
                        <div class="col-8">
                            <select class="form-control select2 table">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12" id="preview"></div>
                    <div class="col-12">
                        <button type="button" class="btn btn-lg btn-primary col-12" id="generer"><?=$json->Generator->genBtn?></button>
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

        $('.select2').select2({
            placeholder: "<?=$json->Generator->chooseElt ?>",
            allowClear: true,
            width: '100%'
        });

        $('.database').on('change', function (e) {
            if ($(this).val().length > 0) {
                $.ajax({
                    url: "<?=WROOT?>Generator/GTable/searchTable",
                    method: "post",
                    type: "json",
                    beforeSend : function (xhr) {
                        $('.table').attr('disabled' , 'true');
                    },
                    data: {
                        database: $(this).val()
                    },
                    success: function (data) {
                        let $option = "<option></option>";
                        data = JSON.parse(data);
                        for (let i = 0; i < data.length; i++) {
                            $option += "<option value='" + data[i].Name + "'>" + data[i].Name + "</option>";
                        }

                        $('.table').html($option);
                        $('.table').removeAttr('disabled');

                    }
                });
            }
        });

        $('.table').on('change', function (e) {
            e.preventDefault();
            if ($('.database').val().length === 0) {
                toast('error', "<?=$json->Generator->chooseDB ?>");
            } else if ($(this).val().length === 0) {
                toast('error', '<?=$json->Generator->chooseTable ?>');
            } else {
                $.ajax({
                    url: "<?=WROOT?>Generator/GCrud/getAttributes",
                    method: "post",
                    dataType: "json",
                    beforeSend : function (xhr) {
                        $('#generer').attr('disabled' , 'true');
                    },
                    data: {
                        database: $('.database').val(),
                        table: $(this).val()
                    },
                    success: function (data) {
                        $('#preview').html("");
                        $html = "";
                        $.each(data, function (i, obj) {
                            $html += `
                            <div class="form-group row">
                                 <div class="col-sm-3">
                                     <input class="form-control" type="text" placeholder="${obj.Field}" disabled="disabled">
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="checkbox">
                                        <input type="checkbox" class="chk-col-blue" class="afficher" id="afficher${i}" checked>
                                        <label for="afficher${i}"><?=$json->Generator->show ?></label>
                                    </div>
                                 </div>
                                 <div class="col-sm-3">
                                    <select class="form-control select2 type">
                                        <option value="number" ${(obj.Type === 'number') ? 'selected' : ''}>Number</option>
                                        <option value="text" ${(obj.Type === 'text') ? 'selected' : ''}>Text</option>
                                        <option value="date" ${(obj.Type === 'date') ? 'selected' : ''}>Date</option>
                                        <option value="time" ${(obj.Type === 'time') ? 'selected' : ''}>Time</option>
                                        <option value="datetime" ${(obj.Type === 'datetime') ? 'selected' : ''}>Date time</option>
                                        <option value="password">Password</option>
                                        <option value="email">Email</option>
                                        <option value="tel">Tel</option>
                                        <option value="file">File</option>
                                    </select>
                                 </div>
                            `;
                            if (obj.Key === 'MUL') {
                                $html += `
                                <div class="col-sm-3">
                                    <select class="form-control select2 foreignkey">
                                        ${$('.table').html()}
                                    </select>
                                 </div>
                                `;
                            }else if (obj.Key === 'PRI'){
                                $html += `
                                <div class="col-sm-3">
                                     <input class="form-control primarykey" type="text" placeholder="${obj.Key}" disabled="disabled">
                                 </div>
                                `;
                            }
                            $html += `</div>`;

                            $('#preview').html($html);
                            $('#generer').removeAttr('disabled');
                        });
                    }
                });
            }
        });

        $('#generer').on('click', function (e) {
            e.preventDefault();
            if ($('.database').length == 0) {
                toast('error', "<?=$json->Generator->chooseDB ?>");
            } else if ($('.table').length == 0) {
                toast('error', "<?=$json->Generator->chooseTable ?>");
            } else {
                let $dataToSend = new Array();
                $('#preview .form-group.row').each(function (i, el) {

                    $dataToSend[i] = {
                        'Id' : i,
                        'Field': $(el).children().find('input:text').attr('placeholder'),
                        'Afficher': $(el).children().find('input:checkbox').is(':checked'),
                        'Type': $(el).children().find('select.type').val(),
                        'ForeignKey': $(el).children().find('select.foreignkey').val(),
                        'PrimaryKey': $(el).children().find('input.primarykey').attr('placeholder')
                    };

                });

                $.ajax({
                    url : '<?=WROOT?>Generator/GCrud/genAjax',
                    method : "post",
                    dataType : "json",
                    data : {
                        database : $('.database').val(),
                        table : $('.table').val(),
                        attributes : $dataToSend
                    },
                    success : function (data) {
                        if (data == 1){
                            toast('success' , 'CRUD <?=$json->Generator->successGen ?>');
                        }else if (data == 0){
                            toast('error' , "<?=$json->Generator->missClass ?>");
                        }else if (data == -3){
                            toast('error' , "<?=$json->Generator->dberr ?>");
                        }else if (data == -2){
                            toast('error' , "<?=$json->Generator->missParam ?>.");
                        }else if (data == -4){
                            toast('error' , "<?=$json->Generator->DbOrTableErr ?>.");
                        }else{
                            toast('error' , "<?=$json->Generator->error ?>");
                        }

                    }
                })
            }
        });
    });
</script>