<!doctype html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= $this->Html->css(['style.css']) ?>
    <?= $this->Html->script(['jquery.min.js', 'popper.js', 'main.js', 'bootstrap.min.js']) ?>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>

<body class="img js-fullheight" style="background-color: white;">




    <?php if (isset($loggedIn) && $loggedIn === true) : ?>
        <div class="encabezado">
            <nav class="top-nav">
                <div class="top-nav-title">
                    //*name & logo of the page
                    <a href="<?= $this->Url->build('/') ?>"><span></span></a>
                </div>
                <div class="top-nav-links">
                    <ul>

                        <li><?= $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout']) ?></li>

                    </ul>
                </div>
            </nav>
        </div>
    <?php endif; ?>
    <section class="ftco-section">
        <section class="ftco-section">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5">
                        <h2 class="heading-section">Cambiar contraseña</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="login-wrap p-0">
                            <h3 class="mb-4 text-center">
                            </h3>


                            <?= $this->Flash->render() ?>

                            <?= //contiene lo que se va a mostar(view)
                            $this->fetch('content') ?>

                        </div>

                    </div>
                </div>
            </div>
        </section>

    </section>



</body>

</html>