<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	
    protected function _initMC() {
        if (get_magic_quotes_gpc()) {
            $in = array(&$_GET, &$_POST, &$_COOKIE);
            while (list($k, $v) = each($in)) {
                foreach ($v as $key => $val) {
                    if (!is_array($val)) {
                        $in[$k][$key] = stripslashes($val);
                        continue;
                    }
                    $in[] = & $in[$k][$key];
                }
            }
            unset($in);
        }
    }

    protected function _initConstants() {
        $registry = Zend_Registry::getInstance();
        $registry->constants = new Zend_Config($this->getApplication()->getOption('constants'));
        foreach ($registry->constants as $key => $value) {
            define($key, $value);
        }
    }
    
}


class FNC{
    /**
    *  Transforme une chaine encodée en UTF-8, et la convertit
    *  en entitiées unicode &#xxx; pour que ça s'affiche correctement
    *  dans les navigateurs, sans forcément tenir compte du meta
    *  content-type charset...
    *  @param String $source la chaine en UTF-8
    *  @return String les entitées
    *  @access public
    *  @see httpwww.php.netutf8_decode
    */


    static function dateFrToTime($date) {
        if ($date != '') {
            $tab = explode('/', $date);
            if (count($tab) == 3) {
                $date = mktime(2, 0, 0, $tab[1], $tab[0], $tab[2]);
            } else {
                $date = false;
            }
        }

        return $date;
    }
 


    static function stringCutter($pStr, $pMaxLen = 40) {
        if (strlen($pStr) > $pMaxLen) {
            $returnStr = '';
            $pieces = preg_split('/ /', $pStr);

            foreach ($pieces as $piece) {
                if (strlen($returnStr . $piece) < $pMaxLen) {
                    $returnStr .= $piece . ' ';
                }
            }

            $returnStr .= ' ...';
        } else {
            $returnStr = $pStr;
        }

        return $returnStr;
    }


    static function getObjetById($coll, $id) {
        foreach ($coll as $ligne) {
            if ($ligne->id == $id) {
                return $ligne;
            }
        }
        return null;
    }


    // date_fr format = d/m/y
    // return yyyy-mm-dd hh:ss:00
    static function dateFrToMysql($date_fr = '') {
        if ($date_fr != '') {
            $date_fr_arr = explode("/", $date_fr);


            if (count($date_fr_arr) == 3) {
                if (intval($date_fr_arr[0]) > 0 && intval($date_fr_arr[1]) > 0 && intval($date_fr_arr[2]) > 1940) {
                    return $date_mysql = $date_fr_arr[2] . '-' . $date_fr_arr[1] . '-' . $date_fr_arr[0] . ' 00:00:00';
                }
            }
        }
        return '0000-00-00 00:00:00';
    }

    static function dateMysqlToFrench($date) {
        $date = new DateTime($date);
        return $date->format("d/m/Y");
    }


    static function safeUrl($str, $replace = array(), $delimiter = '-') {
        $str = trim($str);
        if (!empty($replace)) {
            $str = str_replace((array) $replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    static function writeDynamicRoutes() {
        $fp = fopen(APPLICATION_PATH . "/configs/dynamic_routes.ini", "w+");
        //actualite------------------------------------------------------------------------------------------------------------------
        fputs($fp, "[production]\n\n");

        fputs($fp, 'routes.url_none_xxxx.route = "no-url-test"' . "\n");
        fputs($fp, 'routes.url_none_xxxx.defaults.module = "default"' . "\n");
        fputs($fp, 'routes.url_none_xxxx.defaults.controller = "controller"' . "\n");
        fputs($fp, 'routes.url_none_xxxx.defaults.action = "action"' . "\n");
        fputs($fp, 'routes.url_none_xxxx.defaults.id = 1' . "\n\n");


        $tbl_article = new Application_Model_DbTable_Article();
        $lignes = $tbl_article->fetchAll();
        foreach ($lignes as $ligne) {
            $url = FNC::articleGetUrl($ligne);
            fputs($fp, 'routes.url_article_' . $ligne->id . '.route = "' . $url . '"' . "\n");
            fputs($fp, 'routes.url_article_' . $ligne->id . '.defaults.module = "default"' . "\n");
            fputs($fp, 'routes.url_article_' . $ligne->id . '.defaults.controller = "excursions"' . "\n");
            fputs($fp, 'routes.url_article_' . $ligne->id . '.defaults.action = "details"' . "\n");
            fputs($fp, 'routes.url_article_' . $ligne->id . '.defaults.id = ' . $ligne->id . '' . "\n\n");
        }

        $tbl_transfert = new Application_Model_DbTable_Transfert();
        $lignes = $tbl_transfert->fetchAll();
        foreach ($lignes as $ligne) {
            $url = FNC::transfertGetUrl($ligne);
            fputs($fp, 'routes.url_transfert_' . $ligne->id . '.route = "' . $url . '"' . "\n");
            fputs($fp, 'routes.url_transfert_' . $ligne->id . '.defaults.module = "default"' . "\n");
            fputs($fp, 'routes.url_transfert_' . $ligne->id . '.defaults.controller = "transferts"' . "\n");
            fputs($fp, 'routes.url_transfert_' . $ligne->id . '.defaults.action = "details"' . "\n");
            fputs($fp, 'routes.url_transfert_' . $ligne->id . '.defaults.id = ' . $ligne->id . '' . "\n\n");
        }
    }

    static function cleanHtml($htmlString) {

        $tags = array('style',
            'script',
            'meta',
            'head'
        );
        $text = preg_replace('#<(' . implode('|', $tags) . ')(?:[^>]+)?>.*?</\1>#s', '', $htmlString);
        return $text;
    }

    static function cleanHtmlTags($htmlString) {

        $output = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $htmlString);
        $output = preg_replace('/(<[^>]+) face=".*?"/i', '$1', $output);
        $output = str_replace('font-family', '', $output);

        return $output;
    }

    

    static function MoneyF($somme) {

        $money = self::getMoney();
        if ($money == "dh")
            return number_format(self::EUROtoDH($somme), 0, ',', '') . " Dhs";
        else
            return number_format($somme, 1, ',', '') . " &euro;";
    }

    static function EMoneyF($somme) {
        return number_format($somme, 2, ',', '') . " &euro;";
    }

    static function EMoneyF2($somme) {
        return (number_format($somme, 2, ',', '') . " &euro;");
    }

    static function getMoney() {
        $session_money = new Zend_Session_Namespace('session_money');
        return $session_money->money;
    }

    static function resize($img, $w, $h, $newfilename) {
        //Check if GD extension is loaded
        if (!extension_loaded('gd') && !extension_loaded('gd2')) {
            trigger_error("GD is not loaded", E_USER_WARNING);
            return false;
        }

        //Get Image size info
        list($width_orig, $height_orig, $image_type) = getimagesize($img);

        switch ($image_type) {
            case 1: $im = imagecreatefromgif($img);
                break;
            case 2: $im = imagecreatefromjpeg($img);
                break;
            case 3: $im = imagecreatefrompng($img);
                break;
            default: trigger_error('Unsupported filetype!', E_USER_WARNING);
                break;
        }

        /*         * * calculate the aspect ratio ** */

        $rat1 = $width_orig / $height_orig;
        $rat2 = $w / $h;
        $ho = $height_orig;
        $wo = $width_orig;
        /*
          echo $rat1."<br />";
          echo $rat2."<br /><br />";
          echo $width_orig."--".$height_orig."<br />";
          echo $w."--".$h."<br /><br />";

         */

        if ($rat2 > $rat1) {
            $wo = $width_orig;
            $ho = ($rat2 < 1) ? floor($width_orig * $rat2) : floor($width_orig / $rat2);
        } else {
            $ho = $height_orig;
            $wo = ($rat2 < 1) ? floor($height_orig * $rat2) : floor($height_orig * $rat2);
        }

        //echo $wo."--".$ho."<br />";

        $xo = floor(($width_orig - $wo) / 2);
        $yo = floor(($height_orig - $ho) / 2);

        /*         * * calulate the thumbnail width based on the height ** */

        $newImg = imagecreatetruecolor($w, $h);

        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($image_type == 1) OR ($image_type == 3)) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
            imagefilledrectangle($newImg, 0, 0, $w, $h, $transparent);
        }

        imagecopyresampled($newImg, $im, 0, 0, $xo, $yo, $w, $h, $wo, $ho);
        //Generate the file, and rename it to $newfilename
        switch ($image_type) {
            case 1: imagegif($newImg, $newfilename, 100);
                break;
            case 2: imagejpeg($newImg, $newfilename, 100);
                break;
            case 3: imagepng($newImg, $newfilename, 100);
                break;
            default: trigger_error('Failed resize image!', E_USER_WARNING);
                break;
        }
        
        return $newfilename;
    }

    static function my_resize($img, $w, $h, $newfilename, $recadrer) {
        //Check if GD extension is loaded
        if (!extension_loaded('gd') && !extension_loaded('gd2')) {
            trigger_error("GD is not loaded", E_USER_WARNING);
            return false;
        }

        //Get Image size info
        list($width_orig, $height_orig, $image_type) = getimagesize($img);

        switch ($image_type) {
            case 1: $im = imagecreatefromgif($img);
                break;
            case 2: $im = imagecreatefromjpeg($img);
                break;
            case 3: $im = imagecreatefrompng($img);
                break;
            default: trigger_error('Unsupported filetype!', E_USER_WARNING);
                break;
        }

        /*         * * calculate the aspect ratio ** */

        $rat1 = $width_orig / $height_orig;
        $rat2 = $w / $h;
        $ho = $height_orig;
        $wo = $width_orig;
        /*
          echo $rat1."<br />";
          echo $rat2."<br /><br />";
          echo $width_orig."--".$height_orig."<br />";
          echo $w."--".$h."<br /><br />";

         */
        if ($recadrer) {
            if ($rat2 > $rat1) {
                $w_to_copy = $w;
                $h_to_copy = $height_orig * $w / $width_orig;
            } else {
                $h_to_copy = $h;
                $w_to_copy = $width_orig * $h / $height_orig;
            }
        } else {
            if ($rat2 < $rat1) {
                $w_to_copy = $w;
                $h_to_copy = $height_orig * $w / $width_orig;
            } else {
                $h_to_copy = $h;
                $w_to_copy = $width_orig * $h / $height_orig;
            }
        }



        $xo = floor(($w - $w_to_copy) / 2);
        $yo = floor(($h - $h_to_copy) / 2);

        /*         * * calulate the thumbnail width based on the height ** */

        $newImg = imagecreatetruecolor($w, $h);

        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($image_type == 1) OR ($image_type == 3)) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
            imagefilledrectangle($newImg, 0, 0, $w, $h, $transparent);
        }

        $whiteBackground = imagecolorallocate($newImg, 255, 255, 255);
        imagefill($newImg, 0, 0, $whiteBackground); // fill the background with white

        imagecopyresampled($newImg, $im, $xo, $yo, 0, 0, $w_to_copy, $h_to_copy, $width_orig, $height_orig);
        //Generate the file, and rename it to $newfilename
        switch ($image_type) {
            case 1: imagegif($newImg, $newfilename, 9);
                break;
            case 2: imagejpeg($newImg, $newfilename, 100);
                break;
            case 3: imagepng($newImg, $newfilename, 9);
                break;
            default: trigger_error('Failed resize image!', E_USER_WARNING);
                break;
        }

        return $newfilename;
    }

    static function copyImg($img, $w, $h, $newfilename, $recadrer) {
        list($width_orig, $height_orig, $image_type) = getimagesize($img);
        if ($width_orig == $w && $height_orig = $h) {
            move_uploaded_file($img, $newfilename);
        } else {
            FNC::my_resize($img, $w, $h, $newfilename, $recadrer);
        }
        return 1;
    }

}