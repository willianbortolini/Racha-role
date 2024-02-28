<?php
if (!isset($_SESSION['cookies']) && !isset($_SESSION['id'])) {
    include "aceitarcookies.php";
}
?>
<footer class="footer mt-auto py-3 container">
    <footer class="footer mt-auto py-3 border-top">
        <div class="row">
            <div class="col-md-3 mb-0 text-body-secondary fs-6 ">
                <?php if (isset($store)) { ?>
                    <?php echo $store->stores_name; ?><br>
                    Razão social:<br>
                    <?php echo 'CEP:' . $store->stores_name . ' - ' . $store->neighborhood . ' - ' . $store->city
                        . ' / ' . $store->uf; ?><br>
                <?php } ?>
            </div>
            <?php if (isset($store)) { ?>
                <div class="col-md-3 mb-0 text-body-secondary">

                    <span class="fw-semibold">Contato</span><br>
                    <?php echo $store->whatsapp ?>

                </div>
            <?php } ?>


            <!-- <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="<?php echo URL_BASE   . "home"; ?>" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
        </ul>-->
            <div class="col-md-3 mb-0 text-body-secondary">
                <p class=" text-center text-body-secondary">© 2023 W9B2, Inc</p>
            </div>

            <div class="col-md-3 mb-0 text-center text-body-secondary">
                <div class="row">
                   <!-- <div class="col">
                        <a href="#" class=" text-decoration-none me-3">
                            <i class="bi bi-whatsapp fs-3"></i>
                        </a>
                        <a href="#" class=" text-decoration-none me-3">
                            <i class="bi bi-facebook fs-3"></i>
                        </a>
                        <a href="#" class=" text-decoration-none me-3">
                            <i class="bi bi-instagram fs-3"></i>
                        </a>
                        <a href="#" class=" text-decoration-none me-3">
                            <i class="bi bi-twitter fs-3"></i>
                        </a>
                        <a href="#" class=" text-decoration-none me-3">
                            <i class="bi bi-youtube fs-3"></i>
                        </a>

                    </div>-->
                </div>
            </div>


        </div>
    </footer>
</footer>