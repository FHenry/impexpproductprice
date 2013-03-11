<?php
/* Copyright (C) 2013  Florian HENRY <florian.henry@open-concept.pro>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup	mymodule	MyModule module
 * 	\brief		MyModule module descriptor.
 * 	\file		core/modules/modMyModule.class.php
 * 	\ingroup	mymodule
 * 	\brief		Description and activation file for module MyModule
 */
include_once DOL_DOCUMENT_ROOT . "/core/modules/DolibarrModules.class.php";

/**
 * Description and activation class for module Facturepoids
 */
class modImpExpProductPrice extends DolibarrModules
{

	/**
	 * 	Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * 	@param	DoliDB		$db	Database handler
	 */
	function __construct($db)
	{
		global $langs, $conf;

		$this->db = $db;

		$this->numero = 19997;
		$this->rights_class = 'impexpproductprice';

		$this->family = "technic";

		$this->name = preg_replace('/^mod/i', '', get_class($this));

		$this->description = "Import Export Product Multi Price";

		$this->version = '1.0';

		$this->const_name = 'MAIN_MODULE_' . strtoupper($this->name);

		$this->special = 0;

		$this->picto = 'impexpproductprice@impexpproductprice'; // mypicto@mymodule

		$this->module_parts = array(
			'models' => 1,
		);

		$this->dirs = array();


		$this->config_page_url = array("admin_impexpproductprice.php@impexpproductprice");
		$this->depends = array('invoice');
		$this->requiredby = array();
		$this->phpmin = array(5, 2);
		$this->need_dolibarr_version = array(3, 2, 3);
		$this->langfiles = array("impexpproductprice@impexpproductprice"); // langfiles@mymodule

		$this->const = array();

		$this->tabs = array();

		if ( ! isset($conf->modelwithrefcol->enabled)) $conf->modelwithrefcol->enabled = 0;
		$this->dictionnaries = array();
	

		// Boxes
		// Add here list of php file(s) stored in core/boxes that contains class to show a box.
		$this->boxes = array(); // Boxes list
		$r = 0;
		
		// Permissions
		$this->rights = array(); // Permission array used by this module
		$r = 0;

		// Main menu entries
		$this->menus = array(); // List of menus to add
		$r = 0;

		// Exports
		//--------
		$r++;
		$this->export_code[$r]=$this->rights_class.'_'.$r;
		$this->export_label[$r]="ProductsMultiPrice";	// Translation key (used only if key ExportDataset_xxx_z not found)
		$this->export_permission[$r]=array(array("produit","export"));
		$this->export_fields_array[$r]=array('p.rowid'=>"Id",'p.ref'=>"Ref",
											'pr.price_base_type'=>"PriceLevelPriceBase",'pr.price_level'=>"PriceLevel",
											'pr.price'=>"PriceLevelUnitPriceHT",'pr.price_ttc'=>"PriceLevelUnitPriceTTC",
											'pr.price_min'=>"MinPriceLevelUnitPriceHT",'pr.price_min_ttc'=>"MinPriceLevelUnitPriceTTC",
											'pr.tva_tx'=>'PriceLevelVATRate',
											'pr.date_price'=>'DateCreation');
		$this->export_entities_array[$r]=array('p.rowid'=>"product",'p.ref'=>"product",
											'pr.price_base_type'=>"product",'pr.price_level'=>"product",'pr.price'=>"product",
											'pr.price_ttc'=>"product",
											'pr.price_min'=>"MinPriceLevelUnitPriceHT",'pr.price_min_ttc'=>"MinPriceLevelUnitPriceTTC",
											'pr.tva_tx'=>'product',
											'pr.date_price'=>"product");
		$this->export_sql_start[$r]='SELECT DISTINCT ';
		$this->export_sql_end[$r]  =' FROM '.MAIN_DB_PREFIX.'product as p';
		$this->export_sql_end[$r] .=' LEFT JOIN '.MAIN_DB_PREFIX.'product_price as pr ON p.rowid = pr.fk_product';
		$this->export_sql_end[$r] .=' WHERE p.fk_product_type = 0 AND p.entity IN ('.getEntity("product", 1).')';


		// Imports
		//--------
		$r=0;
		
		$r++;
		$this->import_code[$r]=$this->rights_class.'_'.$r;
		$this->import_label[$r]="ProductsMultiPrice";	// Translation key
		$this->import_icon[$r]=$this->picto;
		$this->import_entities_array[$r]=array();		// We define here only fields that use another icon that the one defined into import_icon
		$this->import_tables_array[$r]=array('pr'=>MAIN_DB_PREFIX.'product_price');
		$this->import_tables_creator_array[$r]=array('pr'=>'fk_user_author');	// Fields to store import user id
		$this->import_fields_array[$r]=array('pr.fk_product'=>"ProductRowid*",
												'pr.price_base_type'=>"PriceLevelPriceBase",'pr.price_level'=>"PriceLevel",
												'pr.price'=>"PriceLevelUnitPriceHT",'pr.price_ttc'=>"PriceLevelUnitPriceTTC",
												'pr.price_min'=>"MinPriceLevelUnitPriceHT",'pr.price_min_ttc'=>"MinPriceLevelUnitPriceTTC",
												'pr.tva_tx'=>'PriceLevelVATRate',
												'pr.date_price'=>'DateCreation*');
		$this->import_regex_array[$r]=array('pr.datec'=>'^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]$');
		$this->import_examplevalues_array[$r]=array('pr.fk_product'=>"1",
											'pr.price_base_type'=>"HT",'pr.price_level'=>"1",
											'pr.price'=>"100",'pr.price_ttc'=>"110",
											'pr.price_min'=>"100",'pr.price_min_ttc'=>"110",
											'pr.tva_tx'=>'19.6',
											'pr.date_price'=>'2013-04-10');


	}

	/**
	 * Function called when module is enabled.
	 * The init function add constants, boxes, permissions and menus
	 * (defined in constructor) into Dolibarr database.
	 * It also creates data directories
	 *
	 * 	@param		string	$options	Options when enabling module ('', 'noboxes')
	 * 	@return		int					1 if OK, 0 if KO
	 */
	function init($options = '')
	{
		$sql = array();

		return $this->_init($sql, $options);
	}

	/**
	 * Function called when module is disabled.
	 * Remove from database constants, boxes and permissions from Dolibarr database.
	 * Data directories are not deleted
	 *
	 * 	@param		string	$options	Options when enabling module ('', 'noboxes')
	 * 	@return		int					1 if OK, 0 if KO
	 */
	function remove($options = '')
	{
		$sql = array();

		return $this->_remove($sql, $options);
	}
}

?>
