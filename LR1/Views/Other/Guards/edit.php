
    <div class="container">
        <h1 class="pt-2 mb-3">Изменение охранника</h1>

        <div class="align-items-center w-50 pt-3 h5">
            <form class="form-control" method="post" enctype="multipart/form-data">

                <label class="pt-3">ФИО</label>
                <input type="text" class="form-control mt-1 input-lg" name="full_name" placeholder="Иван Иванов" value="<?=isset($_POST['full_name'])?htmlspecialchars($_POST['full_name']):($guards['full_name'] ?? "");?>">

                <?php
                if (isset($errors['full_name'])) :
                    ?>
                    <div class="alert alert-warning" role="alert">
                        <?=$errors['full_name']?>
                    </div>
                <?php
                endif;
                ?>

                <label class="pt-3">Биография</label>
                <textarea name="biography" class="form-control" cols="30" rows="3" placeholder="Описание охранника"><?=isset($_POST['biography'])?htmlspecialchars($_POST['biography']):($guards['biography'] ?? "");?></textarea>

                <?php
                if (isset($errors['biography'])) :
                    ?>
                    <div class="alert alert-warning" role="alert">
                        <?=$errors['biography']?>
                    </div>
                <?php
                endif;
                ?>

                <label class="pt-3">Год рождения</label>
                <input type="text" class="form-control mt-1" name="year_of_birth" placeholder="2000" value="<?=isset($_POST['year_of_birth'])?htmlspecialchars($_POST['year_of_birth']):($guards['year_of_birth'] ?? "");?>">

                <?php
                if (isset($errors['year_of_birth'])) :
                    ?>
                    <div class="alert alert-warning" role="alert">
                        <?=$errors['year_of_birth']?>
                    </div>
                <?php
                endif;
                ?>

                <label class="pt-3">Охраняемый пост</label>
                <select class="form-select mt-1" name="guard_post" title="Группа">
                    <?php
                    for($i = 0; $i < count($posts) ; $i++)
                    {
                        if (isset($_POST['guard_post']) && $_POST['guard_post'] == $posts[$i]['id'])
                            echo "<option value=" . $posts[$i]['id'] . " selected>" . $posts[$i]['location'] . "</option>";
                        else if (!isset($_POST['guard_post']) && isset($guards['id_guard_post']) && $guards['id_guard_post'] == $posts[$i]['id'])
                            echo "<option value=" . $posts[$i]['id'] . " selected>" . $posts[$i]['location'] . "</option>";
                        else
                            echo "<option value=" . $posts[$i]['id']. ">" . $posts[$i]['name'] . "</option>";
                    }
                    ?>
                </select>

                <label class="pt-3">Загрузите фотографию продукта</label>
                <input type="file" class="form-control mt-1" placeholder="Фото" name="image" title="Фото">

                <?php
                if (isset($errors['image'])) :
                    ?>
                    <div class="alert alert-warning" role="alert">
                        <?=$errors['image']?>
                    </div>
                <?php
                endif;
                ?>

                <div class="container mt-3 pt-1">
                    <button type="submit" class="btn btn-primary">Изменить</button>
                    <a href="/<?=HOST?>/guards/show" class="btn btn-warning">
                        Назад
                    </a>
                </div>

            </form>
        </div>
    </div>