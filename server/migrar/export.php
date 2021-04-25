<?php

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/migrar.php');

class exportar
{
    /**
     * Exportar los datos del producto
     * 
     * @param int $pid id_product. Id del producto
     * @param int $cid id_product_attribute. Id de la combinacion
     * 
     * @return array
     */
    public function getProductById(int $pid, int $cid=0): array
    {

        $stock = StockAvailable::getQuantityAvailableByProduct((int)$pid, (int)$cid);

        return array(

            'stock'=> $stock

        );
    }
}

//Cargamos la clase.
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
