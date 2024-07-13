<style>
    .input-container {
        position: relative;
        margin: 20px;
    }

    .input-field {
        border: none;
        border-bottom: 2px solid gray;
        outline: none;
        font-size: 16px;
        padding: 5px 0;
        width: 100%;
    }

    .input-field:focus {
        border-bottom: 2px solid blue;
    }

    .input-field::placeholder {
        color: gray;
    }

    .input-field:focus::placeholder {
        color: transparent;
    }
    .deveAvoce {
        color: #00a5a5;
    }

    .voceDeve {
        color: #f79b0c;
    }

    ul li {
        list-style-type: none;
        padding-left: 0;
    }

    .grupo {
        margin-top: 10px;
        background-color: #f1f1f1;
        padding: 8px;
    }

    .lista {
        padding: 0px;
    }

    .footer-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        padding: 10px 0;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
        flex-direction: column;
    }

    .footer-bar2 {
        display: flex;
        width: 100%;
    }

    .footer-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        padding: 10px 0;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
    }

    .footer-bar .btn {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: auto;
        height: 60px;
        font-size: 14px;

    }

    .footer-bar .btn.active {
        background-color: #007bff;
        /* Active color */
    }

    .footer-bar .btn i {
        margin-bottom: 5px;
        font-size: 20px;
    }

    .fixed-bottom-btn {
        width: 70px;
        height: 70px;
        font-size: 20px;
    }

    @media (min-width: 768px) {
        .footer-bar .btn {
            width: auto;
            height: auto;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .footer-bar .btn i {
            margin-bottom: 0;
        }

        .fixed-bottom-btn {
            width: auto;
            height: auto;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 20px;
        }
    }
    .list-group-item {
        cursor: pointer;
        padding: 15px;
        border: none;
        transition: background-color 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item:hover {
        background-color: #f1f1f1;
    }

    .list-group-item .name {
        font-weight: bold;
        font-size: 1.2rem;
        flex-grow: 1;
        text-align: left;
    }

    .list-group-item .amount {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: right;
    }

    .list-group-item .description {
        font-size: 0.9rem;
        text-align: right;
    }

    .list-group-item .valor {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center the items horizontally */
        justify-content: center;
        /* Center the items vertically */
        margin-right: 10px;
    }

    .deveAvoce {
        color: #00a5a5;
    }

    .voceDeve {
        color: #f79b0c;
    }

    .list-group-item .btn-quitar {
        font-weight: 600 !important;
    }
</style>
<h5>
    <?php echo (isset($pagamentos->pagamentos_id)) ? 'Editar Pagamentos' : 'Pagamentos'; ?>
</h5>

<form action="<?php echo URL_BASE   . "Pagamentos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="pagador"></label>
        <select class="form-select" aria-label="Default select example" name="pagador">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_uid'" . ($item->users_uid == $pagamentos->pagador ? "selected" : "") . ">".((empty($item->username)) ? $item->email : $item->username)."</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="recebedor">vai pagar a</label>
        <select class="form-select" aria-label="Default select example" name="recebedor">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_uid'" . ($item->users_uid == $pagamentos->recebedor ? "selected" : "") . ">".((empty($item->username)) ? $item->email : $item->username)."</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2 col-6">
        <label for="valor">Valor</label>
        <input type="number" class="input-field" id="valor" name="valor" step="0.01" value="<?php echo (isset($pagamentos->valor)) ? $pagamentos->valor : ''; ?>" required>
    </div>

    <div class="form-group mb-2 col-6">
        <label for="data">Data</label>
        <input type="date" class="input-field" id="data" name="data" value="<?php echo (isset($pagamentos->data)) ? $pagamentos->data : date('Y-m-d'); ?>" required>
    </div>


    <input type="hidden" name="pagamentos_id" value="<?php echo (isset($pagamentos->pagamentos_id)) ? $pagamentos->pagamentos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="footer-bar">
        <div class="footer-bar2">
            
            <button type="button" onclick="window.history.back()" class="btn btn-primary">Voltar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </div>
</form>