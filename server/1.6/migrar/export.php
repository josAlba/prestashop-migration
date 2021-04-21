<?php

use Symfony\Component\VarExporter\Internal\Exporter;

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/migrar.php');

class exportar
{
    public function getProductById($pid, $cid=0)
    {

        $stock = StockAvailable::getQuantityAvailableByProduct((int)$pid, (int)$cid);

        return array(

            'stock'=> $stock

        );
    }
}

$e = new exportar();

//Comprobar si esta solicitando por id.
if (isset($_GET['pid'])) {
    if (isset($_GET['cid'])) {
        //Producto > Combinacion.
        echo json_encode($e->getProductById((int)$_GET['pid'], (int)$_GET['cid']));
    } else {
        //Producto.
        echo json_encode($e->getProductById((int)$_GET['pid']));
    }
}
