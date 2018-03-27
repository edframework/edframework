<section class="content">
    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?=$json->Generator->showAllFile ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-hover table-responsive">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th><?=$json->Generator->filename ?></th>
                        </tr>
                        <?php foreach ($liste as $key => $l) : ?>
                            <tr>
                                <td><?=$key+1?></td>
                                <td class="fichier"><?=$l['filename']?></td>
                                <td hidden="true"><?=htmlspecialchars($l['contenu'])?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?=$json->Generator->content ?></h3>
                </div>
                <div class="box-body">
                    <pre id="contenu">Code...</pre>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('.fichier').on('click',function () {
            $('#contenu').text($(this).parent().children().eq(2).text());
        });
    });
</script>