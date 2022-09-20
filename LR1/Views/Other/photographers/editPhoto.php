
    <div class="container">
        <h1 class="pt-2 mb-3"><?=$title ?? ""?></h1>

        <div class="d-flex align-items-center flex-column pt-3 h5">
            <form class="" action="photoEdit.php?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">

                <label class="pt-3">Название</label>
                <input type="text" class="form-control mt-1 input-lg" name="name" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):($photographer['name'] ?? "");?>">

                <?php
                    if (isset($errors['name'])) :
                ?>
                    <p class="pt-3"><?=$errors['name']?></p>
                <?php
                    endif;
                ?>

                <label class="pt-3">Описание</label>
                <textarea name="biography" class="form-control" cols="30" rows="3"><?=isset($_POST['biography'])?htmlspecialchars($_POST['biography']):($photographer['biography'] ?? "");?></textarea>

                <?php
                    if (isset($errors['biography'])) :
                ?>
                    <p class="pt-3"><?=$errors['biography']?></p>
                <?php
                    endif;
                ?>

                <label class="pt-3">День рождения</label>
                <input type="text" class="form-control mt-1" name="year_of_birth"  value="<?=isset($_POST['year_of_birth'])?htmlspecialchars($_POST['year_of_birth']):($photographer['year_of_birth'] ?? "");?>">

                <?php
                    if (isset($errors['year_of_birth'])) :
                ?>
                    <p class="pt-3"><?=$errors['year_of_birth']?></p>
                <?php
                    endif;
                ?>

                <label class="pt-3">Тип фотосъёмки</label>
                <select class="form-select mt-1" name="type_photo" title="Тип">
                <?php
                    for($i = 0; $i < count($types) ; $i++)
                    {
                        if (isset($_POST['type_photo']) && $_POST['type_photo'] == ($i + 1))
                            echo "<option value=" . $types[$i]['id'] . " selected>" . $types[$i]['name'] . "</option>";
                        else if (!isset($_POST['type_photo']) && isset($photographer['id_type_photo']) && $photographer['id_type_photo'] == ($i + 1))
                            echo "<option value=" . $types[$i]['id'] . " selected>" . $types[$i]['name'] . "</option>";
                        else
                            echo "<option value=" . $types[$i]['id']. ">" . $types[$i]['name'] . "</option>";
                    }
                ?>
                </select>

                <label class="pt-3">Загрузите фотографию продукта</label>
                <input type="file" class="form-control mt-1" placeholder="Фото" name="image" title="Фото">

                <?php
                    if (isset($errors['image'])) :
                ?>
                    <p class="pt-3"><?=$errors['image']?></p>
                <?php
                    endif;
                ?>

                <button type="submit" class="btn btn-primary mt-3 pt-1">Изменить</button>

            </form>
        </div>
    </div>