
    <div class="container mb-5 pb-3">
        <?php
        if (isset($posts) and count($posts) > 0) :
            ?>
            <h1 class="pt-2 mb-3">Список охранных пунктов</h1>
            <table class="table table-hover table-responsive mt-3 text-center">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Описание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($posts as $key => $item) :
                    ?>
                    <tr>
                        <th><?=$item['id']?></th>
                        <td>
                            <a class="nav-link text-primary" href="/<?=HOST?>/guards/show/<?=$item['id']?>">
                                <?=$item['location']?>
                            </a>
                        <td>
                            <a class="btn btn-primary" id="edit" href="/<?=HOST?>/posts/edit/<?=$item['id']?>">Редактировать</a>
                            <a class="btn btn-danger" href="/<?=HOST?>/posts/delete/<?=$item['id']?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        else:
            ?>
            <h1 class="pt-2 mb-3">Охранных пунктов нет</h1>
        <?php
        endif;
        ?>
        <a class="btn btn-primary btn-lg mb-5" type="button" href="/<?=HOST?>/posts/add">Добавить</a>
    </div>