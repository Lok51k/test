
    <div class="container mb-5 pb-3">
        <?php
        if (isset($guards) && count($guards) > 0) :
            ?>
            <h1 class="pt-2 mb-3">Список охранников</h1>
            <table class="table table-hover table-responsive mt-3">
                <thead>
                <tr>
                    <th>id</th>
                    <th>ФИО</th>
                    <th>Биография</th>
                    <th>Охраняемый пункт</th>
                    <th>Год рождения</th>
                    <th>Фото</th>
                    <th colspan="2"></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($guards as $key => $item) :
                    ?>
                    <tr>
                        <th><?=$item['id']?></th>
                        <td><?=htmlspecialchars($item['full_name'])?></th>
                        <td><?=$item['biography']?></td>
                        <td><?=htmlspecialchars($item['guard_post'])?></td>
                        <td><?=$item['year_of_birth']?></td>
                        <td><img alt="<?=$item['full_name']?>" width="100" src="/<?=HOST?>/Source/items/<?=$item['img_path']?>"></td>
                        <td><a class="btn btn-primary" type="button" href="/<?=HOST?>/guards/edit/<?=$item['id']?>">Редактировать</a>
                        <a class="btn btn-danger delete_guard" id="<?=$item['id']?>" data-entityname="student">Удалить</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        else:
            ?>
            <h1 class="pt-2 mb-3">Охранников нет</h1>
        <?php
        endif;
        ?>
        <a class="btn btn-primary btn-lg mb-5" type="button" href="/<?=HOST?>/guards/add">Добавить</a>
    </div>