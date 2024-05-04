<!-- categorias -->
<div class=" bg-light">
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
        <div class="collapse navbar-collapse " id="navbarCategories">
            <ul class="navbar-nav ">

                <?php foreach ($categories as $item) { ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo ((isset($category)) && ($category == $item->categories_id)) ? 'active' : ''; ?>"
                            href="<?php echo URL_BASE . ((isset($_SESSION['domain']))?$_SESSION['domain'].'/': '')  . "Equipment/EquipmentCategory/" . $item->categories_id ?>">
                            <?php echo $item->categories_name ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    </div>
</div>