<?php
header("location:paginas/CU_inicio");
unlink("instalador/ajax/crearDB.php");
rmdir("instalador/ajax");
rmdir("instalador");
?>