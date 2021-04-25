<?php

if (!defined('_PS_VERSION_')) {
    exit();
}
    
class migrar extends Module
{
    public function __construct()
    {
        $this->name = 'migrar';
        $this->tab = 'front_office_features';
        $this->version = '0.0.1';
        $this->author ='JosAlba';
        $this->need_instance = 0;
        //Da el aspecto de bootstrap.
        //$this->bootstrap = true;
        $this->ps_versions_compliancy = array(
            'min' => '1.6.0.0', 'max' => _PS_VERSION_
        );

        parent::__construct();

        $this->displayName = $this->l('Migrar');
        $this->description = $this->l('Migrar datos de un prestashop');
        $this->confirmUninstall = $this->l('¿Estás seguro de que quieres desinstalar el módulo?');
    }

    /**
     * Devuelve un array con las tiendas.
     * @return Array Tiendas.
     */
    private function getSites()
    {
        $Tiendas = Db::getInstance()->executeS('SELECT `id_shop`,`name` from `' . _DB_PREFIX_ . 'shop`');
    
        $buffero = array();

        foreach ($Tiendas as $value) {
            $buffero[] = array(
                    'id_shop'   => $value['id_shop'],
                    'name'      => $value['name']
                );
        }

        return $buffero;
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }
        
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }
             
        return true;
    }

    public function reset()
    {
        if (!$this->uninstall(false)) {
            return false;
        }
        if (!$this->install(false)) {
            return false;
        }

        return true;
    }

}
