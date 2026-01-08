<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>I-CONNECT</title>
</head>
<body>
<header>
    <h1>HEADER</h1>
    <?php
        if (isset($contenuMenu))
            echo $contenuMenu;
    ?>

</header>

<main>
    <h1>Contenu du site : </h1>
    <?php
        if (isset($contenu))
            echo $contenu;
    ?>

</main>

<footer>
    <div class="d-flex justify-content-center border">
        <div class="m-5 btn btn-danger">Antoine Chen</div>
        <div class="m-5 btn btn-primary">JC Lay</div>
        <div class="m-5 btn btn-success">Thai-nam Ngo-Marie</div>
    </div>
</footer>
</body>
</html>