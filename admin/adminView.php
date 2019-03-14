<?php session_start();



require_once "adminController.php";



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="stylesheet" href="../public/bootstrap/css/bootstrap.css">
    <script src="../public/jquery/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="../public/bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" href="../public/images/logo.png" />
    <title>Espace Administrateur</title>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" id="nomSite">Espace Administration</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
                <li><a href="../index.php?&action=deconnexion" alt="Déconnexion" class = "liens">
                        <span class="glyphicon glyphicon-log-in"></span> Se déconnecter</a></li>
        </ul>
    </div>
</div>
<?php if(isset($texte)) {
        require "../utilities/windowModal.php";
      } ?>

<div class="container hautPage">
    <div class="row">
        <div class="col-lg-12">
            <!--     creation table d'archive-->
          <h3 class="titrePartie">Créer une table d'archive</h3>
        </div>
        <div class="col-lg-12">
            <form action="adminView.php?&action=creer" method="post" class="form-inline">
                <div class="form-group espaceInline">
                    <label for="nomTable">Année : </label>
                    <input type="text" id="nomTable" name="nomTable" class="form-control">
                </div>
                <div class="form-group">
                    <label for="type">Structure :</label>
                    <select id="type" name="type" class="form-control">
                        <option value="utilisateur">utilisateur</option>
                        <option value="trajet">trajet</option>
                    </select>
                </div>
                <button type="submit" class="boutonAdmin">Créer</button>
            </form>
        </div>
    </div>

    <hr id="ligneSep">

    <div class="row">
        <!--    archivage d'une table -->
        <div class="col-lg-12">
            <h3 class="titrePartie">Archiver une table</h3>
        </div>
        <div class="col-lg-12">
            <form action="adminView.php?&action=archiver" method="post" class="form-inline">
                <div class="form-group espaceInline">
                    <label for="tableCible">Table à archiver :</label>
                    <select id="tableCible" name="tableCible" class="form-control">
                        <option value="utilisateurtest">utilisateurtest</option>
                        <option value="trajettest">trajettest</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tableArchive">Table d'archive :</label>
                    <select id="tableArchive" name="tableArchive" class="form-control">
                        <?php while($row = $tables->fetch()) { ?>
                            <?php if($row['Tables_in_blahtakicarv2'] != "trajet" && $row['Tables_in_blahtakicarv2'] != "utilisateur") { ?>
                                <?php $tbls .= $row['Tables_in_blahtakicarv2'].';'; ?>
                                <option value="<?= $row['Tables_in_blahtakicarv2'];?>"><?= $row['Tables_in_blahtakicarv2']?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="boutonAdmin">Archiver</button>
            </form>
        </div>
    </div>


    <?php
    if(isset($tbls)) {
        $listeTable = explode(';', $tbls);
    }
    ?>
    <hr id="ligneSep">

    <div class="row">
        <div class="col-lg-12">
            <h3 class="titrePartie">Supprimer table</h3>
        </div>
        <!--    suppression table archive -->
        <div class="col-lg-12">
            <form action="adminView.php?&action=supprimer" method="post" class="form-inline">
                <div class="form-group">
                    <label for="nom">Nom de la table :</label>
                    <select id="nom" name="nomTable" class="form-control">
                        <?php foreach($listeTable as $table) { ?>
                            <?php if(!empty($table)) { ?>
                                <option value="<?= $table ; ?>"><?= $table; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="boutonSuppr">Supprimer</button>
            </form>
        </div>
    </div>
</div>




</body>
</html>


