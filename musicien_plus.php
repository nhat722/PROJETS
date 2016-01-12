<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_COOKIE["NOM_USER"]))
    {
        if(isset($_SESSION["NOM_USER"]))
            $nom = $_SESSION["NOM_USER"];
    }
    else $nom = $_COOKIE["NOM_USER"];
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HelloWorld - Musicien</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <?php
        $driver = 'sqlsrv';
        $host = 'INFO-SIMPLET';
        $nomDb = 'Classique_Web';
        $user = 'ETD'; $password = 'ETD';
        // Chaine de connexion
        $pdodsn = "$driver:Server=$host; Database=$nomDb";
        // Connexion PDO
        $pdo = new PDO($pdodsn, $user, $password);
        $query_title = "select Nom_Musicien, Prénom_Musicien, Année_Naissance, Année_Mort, Nom_Pays from Musicien inner join Pays on Pays.Code_Pays = Musicien.Code_Pays where Code_Musicien = " . $_GET['code'];
        foreach ($pdo->query($query_title) as $row) {
            $title = $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] ;
        }
        echo "<title>".  $title. "</title>";
    ?>
    <meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
    <link rel="stylesheet" media="screen" type="text/css" href="css/index.css"/>
    <link rel="stylesheet" media="screen" type="text/css" href="css/album.css"/>
    <!--<link href="css/APP.CSS" rel="stylesheet">->

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    


</head>

<body id="page-top" class="index" ng-app="myApp">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">HelloWorld</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">À nous</a>
                    </li>
                    <li>
                        <a href="orchestres.php">Orchestres</a>
                    </li>
                    <li>
                        <a href="album.php">Album</a>
                    </li>
                    
                    <li>
                        <a class="page-scroll" href="#other">Other</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                </ul>
                
               
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Bienvenue à mon website!</div>
                <div class="intro-heading">Ravi de vous rencontrer</div>
                <a href="#about" class="page-scroll btn btn-xl">Parle plus</a>
            </div>
        </div>
    </header>

    <!--Musicien-bix-->
    <div class="full-banner">
        <div class="container-2">
        <?php echo "<img src='image/" . $_GET['type'] . ".jpg'>"; ?>
            <div class="box-info-artist">
                <div class="info-artis fluid">
                    <div class="inside">
                        <?php echo "<img src='photo_musicien.php?code=" . $_GET['code']  . "' onerror=\"this.src='image/pas_de_photo.jpg'\" >"; ?>
                        <div class="info-summary">
                            <div class="info-summary-title">
                                <?php 
                                    foreach ($pdo->query($query_title) as $row) {
                                        echo "<h1>" . $title . "</h1>";
                                        echo "<p> Birthday: " . $row[utf8_decode('Année_Naissance')] . "</p>";
                                        echo "<p> Died: " . $row[utf8_decode('Année_Mort')] . "</p>";
                                        echo "<p> Country: " . $row['Nom_Pays'] . "</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap-body group page-artist-all page-artist container-2">
        <div class="wrap-2-col">
            <div class="wrap-content">
                <h2 class="title-section"> <a> Oeuvre </a> </h2>
                <div class="list-item full-width">
                    <ul class="playlist">
                        <?php
                            switch ($_GET['type']) {
                                case "composer" :
                                    $query_oeuvre = "select distinct Titre,Enregistrement.Code_Morceau from Enregistrement inner join (Composition inner join(Composition_Oeuvre inner join (Oeuvre inner join Composer on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre) on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre) on Composition.Code_Composition = Composition_Oeuvre.Code_Composition) on Composition.Code_Composition = Enregistrement.Code_Composition where Code_Musicien =" . $_GET['code'] ." order by Titre";   
                                    break;
                                case "directeur" :
                                    $query_oeuvre = "select distinct Titre,Enregistrement.Code_Morceau from Enregistrement inner join Direction on Enregistrement.Code_Morceau = Direction.Code_Morceau where Code_Musicien =" . $_GET['code'] . " order by Titre";
                                    break;
                                case "interpreter" :
                                    $query_oeuvre = "select distinct Titre,Enregistrement.Code_Morceau from Enregistrement inner join Interpréter on Enregistrement.Code_Morceau = Interpréter.Code_Morceau where Code_Musicien =" . $_GET['code'] . " order by Titre";
                                    break;
                            }
                            foreach ($pdo->query($query_oeuvre) as $row) {
                                echo "<li class='fn-playlist-item fn-song'>";
                                echo "  <div class='item-song'>";
                                echo "<h3> <a class='fn-name' href='oeuvre_plus.php?code_morceau=".$row['Code_Morceau']."'' title='". $row['Titre'] . "'>" . $row['Titre'] . " </a> </h3>";
                                echo "  </div>";
                                echo "</li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="wrap-content">
                <h2 class="title-section"> <a> Album </a> </h2>
                <div class="list-item full-width">
                        <?php
                            switch ($_GET['type']) {
                                case "composer" :
                                    $query_album = "select distinct Album.Code_Album, Titre_Album, Nom_Musicien, Année_Album from 
                                            Musicien inner join 
                                                (Composer inner join
                                                (Oeuvre inner join 
                                                (Composition_Oeuvre inner join 
                                                (Composition inner join 
                                                (Enregistrement inner join 
                                                (Composition_Disque inner join 
                                                (Album inner join Disque on Album.Code_Album = Disque.Code_Album) 
                                                    on Composition_Disque.Code_Disque = Disque.Code_Disque) 
                                                    on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau) 
                                                    on Enregistrement.Code_Composition = Composition.Code_Composition) 
                                                    on Composition.Code_Composition = Composition_Oeuvre.Code_Composition) 
                                                    on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre) 
                                                	on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre) 
                                            		on Musicien.Code_Musicien = Composer.Code_Musicien 
                                        where Composer.Code_Musicien = ". $_GET['code'];
                                    break;
                                case "interpreter" : 
                                    $query_album = "select distinct Album.Code_Album, Titre_Album, Nom_Musicien, Année_Album from 
                                            Musicien inner join 
                                                            (Interpréter inner join 
                                                            (Enregistrement inner join 
                                                            (Composition_Disque inner join 
                                                            (Album inner join Disque on Album.Code_Album = Disque.Code_Album) 
                                                                on Composition_Disque.Code_Disque = Disque.Code_Disque) 
                                                                on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau) 
                                                                on Enregistrement.Code_Morceau = Interpréter.Code_Morceau)  
                                                                on Musicien.Code_Musicien = Interpréter.Code_Musicien 
                                        where Interpréter.Code_Musicien = ". $_GET['code'];
                                    break;
                                case "directeur" :
                                    $query_album = "select distinct Album.Code_Album, Titre_Album, Nom_Musicien, Année_Album from 
                                            Musicien inner join 
                                                            (Direction inner join 
                                                            (Enregistrement inner join 
                                                            (Composition_Disque inner join 
                                                            (Album inner join Disque on Album.Code_Album = Disque.Code_Album) 
                                                                on Composition_Disque.Code_Disque = Disque.Code_Disque) 
                                                                on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau) 
                                                                on Enregistrement.Code_Morceau = Direction.Code_Morceau)  
                                                                on Musicien.Code_Musicien = Direction.Code_Musicien 
                                        where Direction.Code_Musicien = ". $_GET['code'];
                                    break;
                            }
                            foreach ($pdo->query($query_album) as $row) {
                                echo "<div class='pone'>
                                    <div class='item'>
                                    <a title='". $row['Titre_Album'] . "' href='album_plus.php?code_album=" . $row['Code_Album'] . "' class='thumb'>
                                        <img width='240' src='photo_album.php?code=" . $row['Code_Album'] . "' title='". $row['Titre_Album'] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />
                                    </a>
                                    <div class='description'>
                                        <h2 class='title-item ellipsis'>
                                            <a title='". $row['Titre_Album'] . "' href='album_plus.php?code_album=". $row['Code_Album'] ."'>" . $row['Titre_Album'] . "</a>
                                        </h2>
                                        <div class='inblock ellipsis'>
                                            <h4 class='title-sd-item'> <a href=''>" . $row[utf8_decode('Année_Album')] . " </a> </h4>
                                        </div>
                                    </div> </div> </div>";
                            }
                        ?>          
                </div>
            </div>
            <?php 
                switch ($_GET['type']) {
                    case "directeur" :
                        $query_do = "select distinct Nom_Orchestre from Direction inner join Orchestres on Direction.Code_Orchestre = Orchestres.Code_Orchestre";
                        echo "<div class='wrap-content'>
                                <h2 class='title-section'> <a> Orchestre </a> </h2>
                                <div class='list-item full-width'>
                                    <ul class='playlist'>";
                                        foreach ($pdo->query($query_do) as $row) {
                                            echo "<li class='fn-playlist-item fn-song'>
                                                    <div class='item-song'>
                                                        <h3>" . $row['Nom_Orchestre'] . "</h3>
                                                    </div>
                                                </li>";
                                            }
                        
                                echo"</ul>
                                </div> </div>";
                        break;
                    case "interpreter" :
                        $query_ii = "select distinct Interpréter.Code_Instrument,Nom_Instrument from Instrument inner join Interpréter on Instrument.Code_Instrument = Interpréter.Code_Instrument where Code_Musicien=" . $_GET['code'];
                        echo "<div class='wrap-content'>
                                <h2 class='title-section'> <a> Instrument </a> </h2>
                                <div class='list-item full-width'>
                                    <ul class='instrument'>";
                                        foreach ($pdo->query($query_ii) as $row) {
                                            echo "<li>
                                                    <img src='photo_instrument.php?code=" . $row['Code_Instrument'] . "' title='". $row['Nom_Instrument'] . "' onerror=\"this.src='image/pas_de_photo.jpg'\" />
                                                    <h3> ". $row['Nom_Instrument'] . "</h3>
                                            </li>";
                                        } 
                                echo"</ul>
                                </div> </div>";                                 
                        break;          
                    }   
            ?>
        </div>
    </div>
    <!--/Musicien-bix-->
    
    

   

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>

</html>
