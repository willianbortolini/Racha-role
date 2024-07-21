<style>
    .list-group-item {
        cursor: pointer;
        padding: 15px 0px;
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


    .btn-container {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .btn-container .btn {
        margin-top: 5px;
        white-space: nowrap;
    }

    .list-group-item .pix {
        font-weight: 400;
        color: #6f6f6f;
        font-size: medium;
    }

    .footer-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        padding: 10px 0 20px 0px;
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
        width: 70px;
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

    .card-body {
        background-color: #ECCBAC;
    }
</style>
<div class="mt-2">
    <a href="<?php echo URL_BASE . 'amigos/create' ?>" class="btn btn-outline-secondary"> <i class="fa fa-plus"></i>
        Adicionar amigo</a>
</div>

<div class="card mt-2">
    <div class="card-body">
        <h5 class="card-title">No total,</h5>
        <?php if ($saldo > 0) { ?>
            <p class="card-text">Devem a você <span class="deveAvoce">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
            </p>
        <?php } else { ?>
            <p class="card-text">Você deve <span class="deveAvoce">R$ <?= number_format($saldo * -1, 2, ',', '.') ?></span>
            </p>
        <?php } ?>
    </div>
</div>

<div class="inf">
    <ul class="list-group">
        <?php foreach ($minhasDespesas as $despesa) { ?>
            <li class="list-group-item"
                onclick="location.href='<?php echo URL_BASE . 'despesas/detalhe/' . $despesa->users_uid ?>'">
                <?php if (!empty($despesa->foto_perfil)) { ?>
                    <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                        <img src="<?= URL_IMAGEM_150 . $despesa->foto_perfil ?>" alt="Profile Image" class="rounded-circle"
                            style="width: 50px; height: 50px; object-fit: cover;">
                    </div>
                <?php } ?>
                <div class="name" style="display: inline-block; vertical-align: middle;">
                    <?= (empty($despesa->username)) ? $despesa->email : $despesa->username ?>
                    </br>
                    <?php echo (isset($despesa->pix)) ? "<span class='pix'>pix: " . $despesa->pix . " </span> " : "" ?>
                </div>
                <?php if ($despesa->valor > 0) { ?>
                    <div class="valor">
                        <span class="description deveAvoce">deve a você</span>
                        <span class="amount deveAvoce">R$ <?= number_format($despesa->valor, 2, ',', '.') ?></span>
                    </div>

                <?php } else { ?>
                    <div class="valor">
                        <span class="description voceDeve">você deve</span>
                        <span class="amount voceDeve">R$ <?= number_format($despesa->valor * -1, 2, ',', '.') ?></span>
                    </div>
                <?php } ?>

            </li>
        <?php } ?>
    </ul>

    <ul class="list-group">
        <?php foreach ($todosAmigos as $amigo) { ?>
            <?php if ($amigo->users_uid != $_SESSION['uid']) { ?>
                <li class="list-group-item"
                    onclick="location.href='<?php echo URL_BASE . 'despesas/detalhe/' . $amigo->users_uid ?>'">
                    <?php if (!empty($amigo->foto_perfil)) { ?>
                        <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                            <img src="<?= URL_IMAGEM_150 . $amigo->foto_perfil ?>" alt="Profile Image" class="rounded-circle"
                                style="width: 50px; height: 50px; object-fit: cover;">
                        </div>
                    <?php } ?>
                    <div class="name" style="display: inline-block; vertical-align: middle;">
                        <?= (empty($amigo->username)) ? $amigo->email : $amigo->username ?></br>
                        <?php echo (isset($amigo->pix)) ? "<span class='pix'>pix: " . $amigo->pix . " </span> " : "" ?>
                    </div>

                </li>
            <?php } ?>
        <?php } ?>
    </ul>

    <div class="footer-bar">

        <a href="<?php echo URL_BASE . 'amigos/home' ?>"
            class="btn <?php echo ($btnAtivo == "amigos") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
            <i class="fa fa-user-friends"></i>
            <span>Amigos</span>
        </a>
        <a href="<?php echo URL_BASE . 'Grupos/home' ?>"
            class="btn <?php echo ($btnAtivo == "grupos") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
            <i class="fa fa-users"></i>
            <span>Grupos</span>
        </a>

        <a href="<?php echo URL_BASE . 'Despesas/create' ?>" class="btn btn-outline-secondary">
            <i class="fa fa-plus"></i>
            <span>Adicionar</span>
        </a>
        <a href="<?php echo URL_BASE . 'pagamentos/create' ?>"
            class="btn <?php echo ($btnAtivo == "pagamentos") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
            <i class="fa fa-money-bill"></i>
            <span>Pagar</span>
        </a>
        <a href="<?php echo URL_BASE . 'users/edit/' . $_SESSION['id'] ?>"
            class="btn <?php echo ($btnAtivo == "perfil") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
            <i class="fa fa-user"></i>
            <span>Perfil</span>
        </a>

    </div>
</div>

<script type="module">
   /* // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "AIzaSyB3Jhp9_OWc8O8xtrGCDWLugeLK0gATMUE",
        authDomain: "racha-role.firebaseapp.com",
        projectId: "racha-role",
        storageBucket: "racha-role.appspot.com",
        messagingSenderId: "716135852152",
        appId: "1:716135852152:web:16c6bd5077f6adbf09258d"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    navigator.serviceWorker.register("<?php echo URL_BASE ?>service - worker.js").then(registration => {
    getToken(messaging, {
        serviceWorkerRegistration: registration,
        vapidKey: 'BG3_X9Vofsg3fEYvjY14WXwhLcGqj5cvEssjkec1lRSa1W79uirtujZWjXeYFBbQapYyKrQpQBRC8q0qbMlp2DA'
    }).then((currentToken) => {
        if (currentToken) {
            fetch('<?php echo URL_BASE ?>users/saveSubscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    subscription: currentToken,
                    userId: <?php echo $_SESSION['id'] ?>
                })
            }).then(response => {
                if (response.ok) {
                    console.log('Subscription saved successfully.');
                } else {
                    console.log('Failed to save subscription.');
                }
            }).catch((error) => {
                console.error('Error saving subscription:', error);
            });
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
            // ...
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        // ...
    });
    });*/

    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

    // Your web app's Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyB3Jhp9_OWc8O8xtrGCDWLugeLK0gATMUE",
        authDomain: "racha-role.firebaseapp.com",
        projectId: "racha-role",
        storageBucket: "racha-role",
        messagingSenderId: "716135852152",
        appId: "1:716135852152:web:16c6bd5077f6adbf09258d"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    // Function to request permission and get token
    async function requestPermissionAndGetToken() {
        try {
            const registration = await navigator.serviceWorker.register("<?php echo URL_BASE ?>service-worker.js");
            const currentToken = await getToken(messaging, {
                serviceWorkerRegistration: registration,
                vapidKey: 'BG3_X9Vofsg3fEYvjY14WXwhLcGqj5cvEssjkec1lRSa1W79uirtujZWjXeYFBbQapYyKrQpQBRC8q0qbMlp2DA'
            });

            if (currentToken) {
                await saveSubscription(currentToken);
            } else {
                console.log('No registration token available. Request permission to generate one.');
                await Notification.requestPermission();
                const newToken = await getToken(messaging, {
                    serviceWorkerRegistration: registration,
                    vapidKey: 'BG3_X9Vofsg3fEYvjY14WXwhLcGqj5cvEssjkec1lRSa1W79uirtujZWjXeYFBbQapYyKrQpQBRC8q0qbMlp2DA'
                });
                if (newToken) {
                    await saveSubscription(newToken);
                }
            }
        } catch (error) {
            console.error('Error getting token:', error);
        }
    }

    // Function to save subscription
    async function saveSubscription(token) {
        try {
            const response = await fetch('<?php echo URL_BASE ?>users/saveSubscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    subscription: token,
                    userId: <?php echo $_SESSION['id'] ?>
                })
            });

            if (response.ok) {
                console.log('Subscription saved successfully.');
            } else {
                console.log('Failed to save subscription.');
            }
        } catch (error) {
            console.error('Error saving subscription:', error);
        }
    }

    // Initialize messaging and request permission
    requestPermissionAndGetToken();

    // Handle incoming messages
    onMessage(messaging, (payload) => {
        console.log('Message received. ', payload);
        // Customize notification here if needed
    });

</script>