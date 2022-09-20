
    <div class="container">
        <h1 class="pt-2 mb-3"><?=$header ?? ""?></h1>

        <div class="d-flex align-items-center flex-column pt-3 h5">
            <form class="" action="typeAdd.php" method="post" enctype="multipart/form-data">

                <label class="pt-3">Название</label>
                <input type="text" class="form-control mt-1 input-lg" name="name" placeholder="Название продукта" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):($text['name'] ?? " ");?>">

                <?php
                    if ($errors != null) :
                ?>
                    <p class="pt-3"><?=$errors?></p>
                <?php
                    endif;
                ?>

                <button type="submit" class="btn btn-primary mt-3 pt-1">Добавить</button>

            </form>
        </div>
    </div>