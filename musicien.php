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
    <meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
    <link href="css/musicien.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
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
                        <a class="page-scroll" href="musicien.php">Musicien</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="instrument.php">Instrument</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="interpreteur.php">Interpreteur</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="signup.php">S'inscrire</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="login.php">Connexion</a>
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
                <div class="intro-lead-in">Tous les musiciens</div>
                <div class="intro-heading">Ravi de vous rencontrer</div>
            </div>
        </div>
    </header>

    <!--Musicien-->
    <?php
        $driver = 'sqlsrv';
        $host = 'INFO-SIMPLET';
        $nomDb = 'Classique_Web';
        $user = 'ETD'; $password = 'ETD';
        // Chaine de connexion
        $pdodsn = "$driver:Server=$host; Database=$nomDb";
        // Connexion PDO
        $pdo = new PDO($pdodsn, $user, $password);
        $query = "Select Nom_Musicien,Prénom_Musicien,Code_Musicien from Musicien order by Nom_Musicien";
    ?>
    <div class="box-content">
        <div class="content-wrap">
            <div class="box-singer-full">
                <div class="title_box_key">
                    <h3> <a title="Musicien" href="musicien.php?init=A"> Musicien </a> </h3>
                    
                </div>
                <ul class="list-singer-item">
                    <?php
                        foreach ($pdo->query($query) as $row) {
                            $query_c = "select Musicien.Code_Musicien from Musicien inner join Composer on Musicien.Code_Musicien = Composer.Code_Musicien where Composer.Code_Musicien =" . $row['Code_Musicien'];
                            $query_d = "select Musicien.Code_Musicien from Musicien inner join Direction on Musicien.Code_Musicien = Direction.Code_Musicien where Direction.Code_Musicien =" . $row['Code_Musicien'];
                            $query_i = "select Musicien.Code_Musicien from Musicien inner join Interpréter on Musicien.Code_Musicien = Interpréter.Code_Musicien where Musicien.Code_Musicien =" . $row['Code_Musicien'];
                            if ($pdo->query($query_c)->fetchColumn() != "") $type = "composer";
                            if ($pdo->query($query_d)->fetchColumn() != "") $type = "directeur";
                            if ($pdo->query($query_i)->fetchColumn() != "") $type = "interpreter";
                            else $type = "composer";
                            echo "<li>";
                            echo "<a title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . "' href='musicien_plus.php?code=". $row['Code_Musicien'] ."&type=". $type ."'>";
                            echo "<img src='photo_musicien.php?code=" . $row['Code_Musicien'] . "' title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />";
                            echo "</a>";
                            echo "<h3>";
                            echo "<a title='". $row['Nom_Musicien'] . " " . $row[utf8_decode('Prénom_Musicien')] . "' href='musicien_plus.php?code=". $row['Code_Musicien'] ."&type=". $type ."'>" . $row['Nom_Musicien'] . ' ' . $row[utf8_decode('Prénom_Musicien')]  . "</a>"; 
                            echo "</h3>";
                            echo "</li>";
                        } 
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
        $pdo=NULL;
    ?>
    <!--/Musicien-->
    
    

   

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
