<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HelloWorld - Album</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/index.css" rel="stylesheet">
    <link href="css/album.css" rel="stylesheet">
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
                        <a class="page-scroll" href="index.php">À nous</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="orchestres.php">Orchestres</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="album.php">Album</a>
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
                <div class="intro-lead-in">Tous Les Albums</div>
                <div class="intro-heading">Pour un gout classique</div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="album-bix">
        <?php
        //include('header.php');
        $driver = 'sqlsrv';
        $host = 'INFO-SIMPLET';
        $nomDb = 'Classique_Web';
        $user = 'ETD'; $password = 'ETD';
        // Chaine de connexion
        $pdodsn = "$driver:Server=$host; Database=$nomDb";
        // Connexion PDO
        $pdo = new PDO($pdodsn, $user, $password);
        if (!isset($_GET['code']))
            $_GET['code'] = 1;
    ?>
    <div class="wrap-2-col">
        <div class="zcontent">
            <?php 
                $query_title = "select Code_Genre, Libellé_Abrégé from Genre where Code_Genre=" . $_GET['code'];
                foreach ($pdo->query($query_title) as $row)
                    $title = $row[utf8_decode('Libellé_Abrégé')];
                echo "<h1 class='title-section'> $title </h1>";
            ?>
            <div class="tab-pane">
                <?php
                    $query = "select Code_Album,Titre_Album, Nom_Editeur, Code_Genre FROM Album inner join Editeur on Album.Code_Editeur = Editeur.Code_Editeur where Code_Genre =" . $_GET['code'] ." order by Année_Album desc";
                    foreach($pdo->query($query) as $row) {
                        echo "<div class='pone-of-four'>";
                        echo "  <div class='item'>";
                        echo "      <a title='". $row['Titre_Album'] . "' href='album_plus.php?code_album=" . $row['Code_Album'] . "' class='thumb'>";
                        echo "          <img width='240' src='photo_album.php?code=" . $row['Code_Album'] . "' title='". $row['Titre_Album'] ."' onerror=\"this.src='image/pas_de_photo.jpg'\" />";
                        echo "      </a>";
                        echo "      <div class='description'>";
                        echo "          <h2 class='title-item ellipsis'>";
                        echo "              <a title='". $row['Titre_Album'] . "' href='album_plus.php?code_album=". $row['Code_Album'] ."'>" . $row['Titre_Album'] . "</a>";
                        echo "          </h2>";
                        echo "          <div class='inblock ellipsis'>";
                        echo "              <h4 class='title-sd-item'>";
                        echo "                  <a href=''>" . $row['Nom_Editeur'] . " </a>";
                        echo "              </h4>";
                        echo "          </div>";
                        echo "      </div>";
                        echo "  </div>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
         <div class="sidebar">
            <div class="mCustomScrollBar">
                <div class="mCustomScrollBox">
                    <div class="mContainer">
                        <ul class="data-list">
                            <li class> Genre </li>
                            <ul>
                                <?php
                                    $query_genre = "select Code_Genre, Libellé_Abrégé from Genre";
                                    foreach ($pdo->query($query_genre) as $row) {
                                        if ($_GET['code'] == $row['Code_Genre'])
                                            echo "<li class='active'>";
                                        else 
                                            echo "<li class>"; 
                                        echo "<a href='album.php?code=" . $row['Code_Genre'] . "' title='" . $row[utf8_decode('Libellé_Abrégé')] . "'>" . $row[utf8_decode('Libellé_Abrégé')] . "</a>";
                                        echo "</li>";
                                    }
                                ?>
                            </ul>
                        </ul>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <?php
        $pdo = null;
    ?>
</section>
    
    
    

    
    
    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contact Us</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" class="btn btn-xl">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Your Website 2014</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    

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
