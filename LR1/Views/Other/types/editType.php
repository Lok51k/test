
        <div class="container">
            <h1 class="pt-2 mb-3"><?=$header ?? ""?></h1>

            <div class="d-flex align-items-center flex-column pt-3 h5">
                <form class="" action="typeEdit.php?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">

                    <label class="pt-3">Название</label>
                    <input type="text" class="form-control mt-1 input-lg" name="name" placeholder="Название продукта" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):($type['name'] ?? "");?>">

                    <?php
                        if ($_POST and empty(trim($_POST['name']))) :
                    ?>
                        <p class="pt-3">Ошибка, вы ничего не ввели</p>
                    <?php
                        endif;
                    ?>

                    <button type="submit" class="btn btn-primary mt-3 pt-1">Изменить</button>

                </form>
            </div>
        </div>