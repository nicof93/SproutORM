<!DOCTYPE html>
<html>
<head>
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
</head>

<body style="padding: 40px;">
<?php
require_once (__DIR__) . '/../autoload.php';
require_once (__DIR__) . '/../Entities/Categoria.php';
require_once (__DIR__) . '/../Entities/Estado.php';
?>
<!--Navigation zone-->
<nav style="background-color: #26a69a">
    <div class="nav-wrapper">
        <a href="" class="brand-logo right"><img src="assets/tea-leaf.ico"></a>
        <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li><a><b><i class="fa fa-leaf"></i> Sprout</b></a></li>
            <li><a>Components</a></li>
            <li><a>JavaScript</a></li>
            <li><a class="dropdown-button" href="#!" data-activates="DBTables">Dropdown
                    <i class="material-icons right">arrow_drop_down</i></a></li>
        </ul>
    </div>
</nav>

<ul id="DBTables" class="dropdown-content">
    <?php

    foreach ($engine->getTables() as $key => $table) { ?>
        <li><a href="?tabla=<?php echo $table; ?>" class="collection-item"><?php echo $table; ?> </a></li>
    <?php } ?>
</ul>

<?php
echo "<h1>DATABASE Tables</h1><br>";

$est1 = new Estado();
$est1->setNombre("Exitoso");
$est1->setDescripcion("Persistido");

$orm->dm->persist($est1);
//$orm->dm->persist(array(new Estado()));


?>
<a class="btn dropdown-button" href="#!" data-activates="ddTables"> Database tables
    <i class="mdi-navigation-arrow-drop-down right"></i></a>
<ul id="ddTables" class="dropdown-content">
    <?php

    foreach ($engine->getTables() as $key => $table) { ?>
        <li><a href="?tabla=<?php echo $table; ?>" class="collection-item"><?php echo $table; ?>
                <span class="badge"><?php echo $key; ?></span>
            </a></li>
    <?php } ?>
</ul>
<?php

echo "<br><h1>PROPERTIES</h1><br>";

//echo "<br><h5>Class Mapper Properties</h5><br>";
$reflector = new \ReflectionClass(\Source\Mapper::class);
//var_dump($reflector->getDefaultProperties());

//echo "<br><h5>Mapper Properties after execute ORM</h5><br>";
//echo json_encode(get_object_vars($orm));


if (!empty($_GET['tabla'])) {
    //echo json_encode($_GET);
    var_dump($orm->dm->getAll($_GET['tabla']));
}

?>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../node_modules/materialize-css/bin/materialize.js"></script>
<script type="application/javascript">
    $(function () {

    });
</script>

</body>
</html>



