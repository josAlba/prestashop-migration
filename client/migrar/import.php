<?php

use Symfony\Component\VarExporter\Internal\Exporter;

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/migrar.php');

class import
{

    public $endpoint;

    //Almacena el stock.
    public function setStockProductById($quantity, $pid, $cid=0,$id_shop=1)
    {

        $stock = StockAvailable::setQuantity((int)$pid, (int)$cid, $quantity, $id_shop);

    }

    //Recuperar todos los productos.
    public function getAllProduct()
    {

    }

    //Recuperar el stock del endpoint.
    public function getStockByEndpoint()
    {

    }
}

$e = new import();