
    <div class="container">
        <h1 class="pt-2 mb-3">Добавление охранного пункта</h1>

        <div class="d-flex align-items-center flex-column pt-3 h5">
            <form class="form-control" method="post" enctype="multipart/form-data">

                <label class="pt-3">Название</label>
                <input type="text" class="form-control mt-1 input-lg" name="location" placeholder="Расположение охранного пункта" value="<?=isset($_POST['location'])?htmlspecialchars($_POST['location']):($text['location'] ?? " ");?>">

                <?php
                if ($errors != null) :
                    ?>
                    <div class="alert alert-warning" role="alert">
                        <?=$errors?>
                    </div>
                <?php
                endif;
                ?>

                <div class="container mt-3 pt-1">
                    <button type="submit" class="btn btn-primary ">Добавить</button>
                    <a class="btn btn-warning" href="/<?=HOST?>/posts/show">Назад</a>
                </div>

            </form>
        </div>
    </div>