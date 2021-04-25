<?php
/**
 * Recorrer todos los productos y solicitar por curl el stock.
 * 
 * 
 * 🔴Falta recorer todas las tiendas.
 * 
 */

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/migrar.php');

class import
{

    /**
     * Endpoint
     */
    public $endpoint;

     /**
     * Recupera todos los productos del sistema.
     * 
     */
    public function getAllProduct()
    {
        $productos = Db::getInstance()->executeS('SELECT `id_product` from `' . _DB_PREFIX_ . 'product`');

        foreach ($productos as $value) {
           
            //Recuperamos las combinaciones del producto.
            $combinaciones = Db::getInstance()->executeS('SELECT `id_product_attribute` from `' . _DB_PREFIX_ . 'product_attribute` WHERE id_product='.$value['id_product']);
            
            //En caso de combinacion.
            if(count($combinaciones)>0){
                foreach ($combinaciones as $combinacion) {

                    $producto = $this->getStockByEndpoint($value['id_product'],$combinacion['id_product_attribute']);

                    if(isset($producto['stock'])){

                        $this->setStockProductById($producto['stock'],$value['id_product'],$combinacion['id_product_attribute']);

                    }
                }
            }else{

                $producto = $this->getStockByEndpoint($value['id_product']);

                if(isset($producto['stock'])){

                    $this->setStockProductById($producto['stock'],$value['id_product'],0);

                }
            }
            
        }
    }

    /**
     * Actualiza el stock del producto.
     * 
     * @param int $quantity Stock
     * @param int $pid id_product. Id del producto
     * @param int $cid id_product_attribute. Id de la combinacion
     * @param int $id_shop id_shop. Id de la tienda
     * 
     */
    public function setStockProductById(
        int $quantity, 
        int $pid, 
        int $cid=0,
        int $id_shop=1
    )
    {

        $stock = StockAvailable::setQuantity((int)$pid, (int)$cid, $quantity, $id_shop);

    }

    /**
     * Solicitar stock del producto a traves del endpoint.
     * @param int $pid id_product. Id del producto
     * @param int $cid id_product_attribute. Id de la combinacion
     * 
     * @return array
     */
    public function getStockByEndpoint(int $pid,int $cid=0): array
    {
        //Endpoint
        $url = $this->endpoint.'?pid='.$pid.'&cid='.$cid;

        //Curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result,true);
    }
}

$e = new import();