
    <div class="container">
        <h1 class="pt-2 mb-3"><?=$header ?? ""?></h1>

        <form class='form-control w-50' method="post" enctype="multipart/form-data">

            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Удалить всех охранников из этого охранного пункта
                </label>
            </div>
            <?php
            if (isset($posts) && count($posts) > 0) {
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Перевести всех охранников на другой охранный пункт
                    </label>
                    <select disabled name="id_post_guard" id="id_post_guard" class="form-select mt-3 w-50">
                        <?php
                        foreach ($posts as $key => $item)
                            echo "<option value=" . $item['id'] . ">" . $item['location'] . "</option>";
                        ?>
                    </select>
                </div>
                <?php
            }
            ?>

            <div class="container mt-3 pt-1">
                <button type="submit" class="btn btn-primary ">Подтвердить</button>
                <a class="btn btn-warning" href="/<?=HOST?>/posts/show">Назад</a>
            </div>

        </form>

    </div>