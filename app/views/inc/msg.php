<div class="alert <?php echo $msg->classe ?> d-flex " role="alert">
    <div class="flex-grow-1">
        <i class="fas <?php echo $msg->icone ?>"></i>
        <?php echo $msg->msg ?>
    </div>
    <button type="button" class="btn-close" aria-label="Close"
        onclick="fecharAlerta(this)"></button>
</div>