
    <div class="container mb-5 pb-3">
        <?php
            if (count($photographers) > 0) :
        ?>
            <h1 class="pt-2 mb-3">Список фотографов</h1>
            <table class="table table-hover table-responsive mt-3">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Имя</th>
                        <th>Тип фотосъёмки</th>
                        <th>Биография</th>
                        <th>День рождения</th>
                        <th>Фото</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>

                <?php
                    foreach ($photographers as $key => $item) :
                ?>
                    <tr>
                        <th><?=$item['id']?></th>
                        <td><?=$item['name']?></th>
                        <td><?=$item['type_name']?></td>
                        <td><?=$item['biography']?></td>
                        <td><?=$item['year_of_birth']?></td>
                        <td><img alt="<?=$item['name']?>" width="100" src="Template/Images/<?=$item['img_path']?>"></td>
                        <td>
                            <a class="btn btn-primary" type="button" id="edit" href="photoEdit.php?id=<?=$item['id']?>">Редактировать</a>
                            <a class="btn btn-danger DeletePhoto" id="<?=$item['id']?>" data-entityname="student">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php
            else:
        ?>
            <h1 class="pt-2 mb-3">Фотографов нет</h1>
        <?php
            endif;
        ?>
        <a class="btn btn-primary btn-lg mb-5" type="button" href="photoAdd.php">Добавить</a>
    </div>