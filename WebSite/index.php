<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../node_modules/materialize-css/bin/materialize.css"
          media="screen,projection"/>
    <!--import Font awesome-->
    <link type="text/css" rel="stylesheet" href="../node_modules/components-font-awesome/css/font-awesome.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>My ORM</title>
    <style>
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .preload {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(assets/img/preload.gif) center no-repeat #fff;
        }
    </style>
</head>

<body style="padding: 40px;">
<div class="preload"></div>

<?php
require_once (__DIR__) . '/../autoload.php';
require_once (__DIR__) . '/../Entities/Categoria.php';
require_once (__DIR__) . '/../Entities/Estado.php';
?>
<!--Navigation zone-->
<nav style="background-color: #26a69a">
    <div class="nav-wrapper">
        <a href="index.php" class="brand-logo right"><img src="assets/tea-leaf.ico"></a>
        <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li><a href="index.php"><b><i class="fa fa-leaf"></i> Sprout</b></a></li>
            <li><a href="test_actions.php">Test actions</a></li>
            <li><a>Documentation</a></li>
            <li><a>About..</a></li>
        </ul>
    </div>
</nav>

<div class="row">
    <div class="col s6" style="border-right: 1px solid #e5e9e2 ">
        <h1>DATABASE Tables</h1>
        <?php
        $DBTables = $engine->getTables();
        $columnsForRow = 6;
        ?>
        <div class="chip">
            <i class="large material-icons">done_all</i>
            <b><?php echo "Found: " . count($DBTables) . ' tables';?></b>
        </div>
        <br>
        <?php
        $rows = array_chunk($DBTables, $columnsForRow);

        foreach ($rows as $index => $row) { ?>
            <div class="row">
                <?php foreach ($row as $value) { ?>
                    <div class="col s2">
                        <div class="card z-depth-3" >
                            <div class="card-image waves-effect waves-block waves-light">
                                <img class="activator" src="assets/img/sprout.png" style="height: 70px; width: 70px;">
                            </div>
                            <div class="card-content">
                                <p class="truncate tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo $value;?>">
                                    <a href="?tabla=<?php echo $value; ?>"><?php echo $value; ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="col s6" style="max-height: 720px;overflow: auto">
        <h1>PROPERTIES</h1><br>
        <?php if (!empty($_GET['tabla'])) {
            var_dump($orm->dm->getAll($_GET['tabla']));
        } ?>
    </div>
</div>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../node_modules/materialize-css/bin/materialize.js"></script>
<script type="application/javascript">
    $(function () {
        $('.preload').fadeOut('slow');
    });
</script>

</body>
<footer class="page-footer" style="bottom: 0px;background-color: #26a69a">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">
                    ORM para mapeo y persistencia de batos. Admite multiples motores SQL (MySql, Oracle, SQL Server, SQLite)
                    creado el 16-07-2016. Actualmente se encuantra en desarrollo y sin ninguna versión estable.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Sprout</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Home</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Test Actions</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Documentation</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">About...</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2016 Nicolas Diaz | Blackrobot
        </div>
    </div>
</footer>
</html>



