<?php if (count($storesUser) > 1) { ?>
    <div class="d-none d-md-block  dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            foreach ($storesUser as $storeuser) {
                if ($storeuser->stores_id == $_SESSION['store']) {
                    echo $storeuser->stores_name;
                }
            }
            ?>
        </button>
        <ul class="dropdown-menu">
            <?php
            foreach ($storesUser as $storeuser) { ?>
                <li><a class="dropdown-item <?php echo ($storeuser->stores_id === $_SESSION['store']) ? 'active' : '' ?>"
                        href="<?php echo URL_BASE . "store/exchangeStore/" . $storeuser->stores_id ?>"> <?php echo $storeuser->stores_name ?> </a></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>