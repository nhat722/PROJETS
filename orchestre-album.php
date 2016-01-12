<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HelloWorld - Orchestres</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <meta http-equiv="Content-Type" content="texthtml; charset=utf-8"/>
    <link href="css/musicienz.css" rel="stylesheet">
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
                <div class="intro-lead-in">Tous les orchestres</div>
                <div class="intro-heading">Ravi de vous rencontrer</div>
            </div>
        </div>
    </header>

    <!--instrument-->
    <?php
      $driver = 'sqlsrv';$host = 'INFO-SIMPLET';$nomDb = 'Classique_Web';
      $user = 'ETD';$password = 'ETD';
      $pdodsn = "$driver:Server=$host;Database=$nomDb";
      // Connexion PDO
      $pdo = new PDO($pdodsn, $user, $password);
       $query = " select DISTINCT Album.Titre_Album, Album.Année_Album, Album.Code_Album
                FROM Album INNER JOIN
                       (Disque inner join 
                       (Composition_Disque INNER JOIN 
                       (Enregistrement INNER JOIN 
                       (Direction INNER JOIN Orchestres ON Direction.Code_Orchestre = Orchestres.Code_Orchestre)
                      ON Enregistrement.Code_Morceau = Direction.Code_Morceau)
                      ON Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau)
                      ON Disque.Code_Disque = Composition_Disque.Code_Disque)
                      ON Album.Code_Album = Disque.Code_Album
                WHERE Orchestres.Code_Orchestre = " . $_GET['Code_Orchestre'];
      echo 
      "<table class=\"table table-bordered\">";
        echo"<tr><th>TITRE ALBUM</th><th>ANNEE</th><th>IMAGE</th></tr>";
        foreach ($pdo->query($query) as $row) {
          echo "<tr>";
          if (empty($row['Titre_Album']))
          {
            echo "<td> pas d'album concerne </td>";
          }
          else 
          {
            echo "<td> <a href=\"album_plus.php?code_album=" . $row['Code_Album'] . "\" >" . $row['Titre_Album']."</td>";
            //echo "<td>" . $row['Titre_Album']."</td>";
          }
          if (empty($row[utf8_decode('Année_Album')]))
          {
            echo "<td> pas d'album concerne </td>";
          }
          else 
          {
            echo "<td>".$row[utf8_decode('Année_Album')]."</td>";
          }
          echo "<td><img src=\"photo_album.php?code=" . $row['Code_Album'] . "\" height=\"100\"></td>";
          echo "</tr>";
          

        }
      echo 
      "</table>";
      $pdo = null;
      ?>
    <!--/Instrument-->
    
    

   

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
