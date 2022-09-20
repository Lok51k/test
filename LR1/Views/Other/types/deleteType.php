
    <div class="container">
        <h1 class="pt-2 mb-3"><?=$header ?? ""?></h1>

        <form class='form-control w-50' action="typeDel.php?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">

            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Удалить все товары из этой категории
                </label>
            </div>
            <?php
                if (isset($types) && count($types) > 0) {
            ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Перенести их в другую категорию
                    </label>
                    <select disabled name="type_photo" id="type_photo" class="form-select mt-3 w-50">
                    <?php
                        foreach ($types as $key => $item)
                        {
                            echo "<option value=" . $item['id'] . ">" . $item['name'] . "</option>";
                        }
                    ?>
                    </select>
                </div>
            <?php
                }
            ?>

            <button type="submit" class="btn btn-primary mt-3 pt-1">Подтвердить</button>
    </div>