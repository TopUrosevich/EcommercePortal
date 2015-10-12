<?php
namespace Findmyrice\External;

use Phalcon\Mvc\User\Component;
use Findmyrice\Models\ProductList;
use Findmyrice\Models\ServiceArea;
use DateTimeZone;
use PHPExcel_IOFactory;
/**
 * Findmyrice\Models\HelpFunctions
 * All the users registered in the application
 */
class External extends Component
{
    public static function searchParams($array){
        if(isset($array) && !empty($array)){
            $array = array_filter($array);
        }
        return $array;
    }

    //only for MongoDB
    public static function returnArrayForSelect($obj)
    {
        $array = array();
        foreach ($obj as $v) {
            $array[(string) $v['_id']] = $v['name'];
        }
        return $array;
    }
    //Countries
    public static function returnArrayForSelectCountries($obj)
    {
        $array = array();
        foreach ($obj as $v) {
            $array[$v->country_name] = $v->country_name;
//            $array[(string)$v->_id] = $v->country_name;
        }
        return $array;
    }
    //Country codes
    public static function returnArrayForSelectCountryCodes($obj)
    {
        $array = array();
        foreach ($obj as $v) {
//            $array[(string)$v->_id] = $v->country_name . ' ' . $v->country_code;
            $array[$v->country_name . ' +' . $v->country_code] = $v->country_name . ' +' . $v->country_code;
        }
        return $array;
    }

    public static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public static function Products_Location($company_id = null){

        //Company Product Lists
        try {
            $company_productLists = ProductList::findByUserId($company_id);
            $productsArr = array();
            if ($company_productLists) {
                foreach ($company_productLists as $key1 => $product_s) {
                    foreach ($product_s as $key => $val) {
                        if (is_object($val)) {
                            $productsArr[$key1][$key] = (string)$val;
                        } else {
                            $productsArr[$key1][$key] = $val;
                        }
                        if ($key == 'pl_size') {
                            $productsArr[$key1][$key] = round($val / 1024, 2);
                        }
                        if ($key == 'pl_uploaded') {
                            $date = date('d M y', $val);
                            $productsArr[$key1][$key] = $date;
                        }
                    }
                }
            }
//            if ($productsArr) {
//                $this->view->products = $productsArr;
//            }

            //ServiceArea
            $ServiceAreas = ServiceArea::findByUserId($company_id);
            $ServiceAreasArr = array();
            if($ServiceAreas){
                foreach($ServiceAreas as $key1 =>$ServiceArea_s){
                    foreach($ServiceArea_s as $key=>$val){
                        if(is_object($val)){
                            $ServiceAreasArr[$key1][$key] = (string)$val;
                        }else{
                            $ServiceAreasArr[$key1][$key] = $val;
                        }
                        if($key == 'product_list_id'){
                            $ProductList = ProductList::findById($val);
                            $ServiceAreasArr[$key1]['product_list_name'] = $ProductList->pl_name;
                        }
                    }
                }
            }
//            if($ServiceAreasArr){
//                $this->view->ServiceAreas = $ServiceAreasArr;
//            }
            $product_and_serviceArea = array();
            if(!empty($productsArr) && !empty($ServiceAreasArr)){
                foreach($productsArr as $k_p=>$products){
                    foreach($ServiceAreasArr as $k_s=>$ServiceArea){

                        if($ServiceArea['product_list_id'] == $products['_id']){
                            $product_and_serviceArea[] = array_merge($products, $ServiceArea);
                        }

                    }

                }

            }
            if(isset($product_and_serviceArea) && !empty($product_and_serviceArea)){
                return $product_and_serviceArea;
            }else{
                return false;
            }

        }catch (\Exception $ep){
            return false;
        }
    }

    // Get Nearest Timezone
    public static function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
        $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
            : DateTimeZone::listIdentifiers();

        if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

            $time_zone = '';
            $tz_distance = 0;

            //only one identifier?
            if (count($timezone_ids) == 1) {
                $time_zone = $timezone_ids[0];
            } else {

                foreach($timezone_ids as $timezone_id) {
                    $timezone = new DateTimeZone($timezone_id);
                    $location = $timezone->getLocation();
                    $tz_lat   = $location['latitude'];
                    $tz_long  = $location['longitude'];

                    $theta    = $cur_long - $tz_long;
                    $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
                        + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                    $distance = acos($distance);
                    $distance = abs(rad2deg($distance));

                    if (!$time_zone || $tz_distance > $distance) {
                        $time_zone   = $timezone_id;
                        $tz_distance = $distance;
                    }

                }
            }
            return  $time_zone;
        }
        return null;
    }
    public static function getGeoData()
    {
        $visit_ip = self::getUserIP();
        $name = "geo_data_".$visit_ip;
        $cookie_name = str_replace(".", "_", $name);
        $geoDataArr = array();
        if(!isset($_COOKIE[$cookie_name])) {
            $ch = curl_init();
            $url = "http://freegeoip.net/json/".$visit_ip;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ;
            $json = curl_exec($ch);
            curl_close($ch);
            $geoData = json_decode($json);

            $cookie_name = "geo_data_".$visit_ip;
            $geoDataArr["country_name"] =  $geoData->country_name;
            $geoDataArr["region_name"] =  $geoData->region_name;
            $geoDataArr["city"] =  $geoData->city;
            setcookie($cookie_name, $json, time() + (86400 * 30 * 30), "/"); //  1 month
        } else {
            $geoData = json_decode($_COOKIE[$cookie_name]);
            $geoDataArr["country_name"] = $geoData->country_name;
            $geoDataArr["region_name"] = $geoData->region_name;
            $geoDataArr["city"] = $geoData->city;
        }
        return $geoDataArr;
    }

    public static function getUserIP()
    {
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = $_SERVER['REMOTE_ADDR'];

            if(filter_var($client, FILTER_VALIDATE_IP))
            {
                $ip = $client;
            }
            elseif(filter_var($forward, FILTER_VALIDATE_IP))
            {
                $ip = $forward;
            }
            else
            {
                $ip = $remote;
            }

            return $ip;
    }


    public static function getArrayProductsFromFile($file_extension, $inputFileName)
    {
        $arrProduct = array();
        if($file_extension =='csv' || $file_extension =='xls' || $file_extension =='xlsx'){
            //  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);

                $worksheet = $objPHPExcel->getActiveSheet();
                $i = 0;
                $category = '';
                foreach ($worksheet->getRowIterator() as $row) {
                    if($row->getRowIndex() == 1){
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                        $header = array();
                        foreach ($cellIterator as $cell) {
                            if (!is_null($cell)) {
                                $header[] =  $cell->getValue();
                            }
                        }
                        if($header[0] != 'Product Name' || $header[1] != 'Unit/Qty' || $header[2] != "Brand"){
                            break;
                        }
                    }
                    if($row->getRowIndex() > 1){
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                        $products = array();
                        foreach ($cellIterator as $cell) {
                            if (!is_null($cell)) {
                                $products[] =  $cell->getValue();
                            }
                        }

                        if(empty($products[1]) && empty($products[2]) ){
                            $category = $products[0];
                            unset($products);
                            continue;
                        }
                        if(!empty($category)){
                            $arrProduct[$i]["product_name"] = trim($products[0]);
                            $arrProduct[$i]["unit_qty"] = trim($products[1]);
                            $arrProduct[$i]["brand"] = trim($products[2]);
                            $arrProduct[$i]["product_category"] = trim($category);
                        }else{
                            $arrProduct[$i]["product_name"] = trim($products[0]);
                            $arrProduct[$i]["unit_qty"] = trim($products[1]);
                            $arrProduct[$i]["brand"] = trim($products[2]);
                            $arrProduct[$i]["product_category"] = 'NO CATEGORY';
                        }
                        $i++;
                        unset($products);
                    }
                }

            } catch(\Exception $e) {
//            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
        }

        return $arrProduct;
    }

    /*
    public static function geoPcGetDataArray($geoPc) {
        if(is_array($geoPc)){
            $result = array();
            foreach($geoPc as $g_k=>$g_val){
                foreach($g_val as $k=>$val){
                    if(is_object($val)){
                        $result[$g_k][$k] = $val;
                    }else{
                        $k_arr = explode(';', $k);
                        $val_arr = explode(';', $val);
                        if(count($k_arr) == count($val_arr)){
                            for($i=0;$i < count($k_arr);$i++){
                                $result[$g_k][$k_arr[$i]] = $val_arr[$i];
                            }
                        }
                    }
                }
            }
            return $result;
        } else {
            return false;
        }
        return false;
    }
    */
}