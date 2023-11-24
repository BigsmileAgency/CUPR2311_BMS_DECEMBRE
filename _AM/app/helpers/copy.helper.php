<?php
include_once "common/copy.php";

// If use Boilerplate
if ($useBoilerplate) {
  // If copy.php file exist, include
  $copy = "_am/boilerplates/".$client."/copy.php";
  if (file_exists($copy)) {
    include_once $copy;
  }
}

/**
 * The manager to call (see its class bellow for details)
 */
$cm = new CopiesManager($copies);

/**
 * Manage the available copies, returning those, if exist, related to the current settings
 */
class CopiesManager extends ArrayObject {
	private $copies;
	private $DOMWrapper;
	private $testableKeys;

	private $language;
	private $format;
	private $version;

	public function __construct(&$copies) {

    // var_dump($copies);

		$this->copies = self::NormalizeArray($copies);
		$this->DOMWrapper = null;
		//-----
		global $language, $format, $version;
		$curLanguage = $language;
		$curFormat = strtolower($format);
		$curVersion = strtolower($version);

		$this->language = $language;
		$this->format = strtolower($format);
		$this->version = strtolower($version);

		$this->testableKeys[] = $curLanguage." ".$curFormat." ".$curVersion;
		$this->testableKeys[] = $curLanguage." ".$curFormat;
		$this->testableKeys[] = $curLanguage." ".$curVersion;
		$this->testableKeys[] = $curFormat." ".$curVersion;
		$this->testableKeys[] = $curLanguage;
		$this->testableKeys[] = $curFormat;
		$this->testableKeys[] = $curVersion;
		$this->testableKeys[] = "";
	}

	// Exposed methods
	//----------------
	/**
	 * Specify the default DOM element wrapper
	 * @param mixed $DOMWrapper Specify the DOM element which will wrap all the copies requested
	 */
	public function SetDOMWrapper($DOMWrapper) {
		$this->DOMWrapper = $DOMWrapper;
	}
	/**
	 * Specify a format to apply to the desired copy id to retrieve
	 * @param mixed $id 					id of the copy to find
	 * @param mixed $DOMWrapper 	DOM element which will wrap the found copy, if given (it override the default DOM wrapper, if specified)
	 * @param string $dataPrefix 	(optional) the data to add before the found copy
	 * @param string $dataSuffix 	(optional) the data to add after the found copy
	 * @return mixed 							the found copy, wrapped in a given or default DOM element, if specified
	 * @throws Exception 					an exception is thrown if the given id is not found in the provided copies
	 */
	public function Format($id, $DOMWrapper, $dataPrefix = "", $dataSuffix = "") {
		return $this->FormatCopy($id, $this->GetCopy($id), $DOMWrapper, $dataPrefix, $dataSuffix);
	}
	/**
	 * Retrieve the desired copy id using brackets operator (copiesManager['id'])
	 * @param int|string $id 			the id to pass through the brackets operator
	 * @return mixed|false 				the found copy, wrapped in a default DOM element, if specified
	 * @throws Exception 					an exception is thrown if the given id is not found in the provided copies
	 */
	public function offsetGet($id) {
		return $this->FormatCopy($id, $this->GetCopy($id));
	}

	// Private methods
	//----------------
	// private static function NormalizeArray($array) {
	// 	$normalizedArray = array();
	// 	foreach ($array as $key => $value) {
  //     var_dump($value);
	// 		if (is_array($value))
	// 		$value = self::NormalizeArray($value);
	// 		$normalizedArray[strtolower($key)] = $value;
	// 	}
	// 	return $normalizedArray;
	// }


  private static function NormalizeArray($array) {
		$normalizedArray = array();

    if (is_array($array))
		foreach ($array as $id => $id_value) {

      if (is_array($id_value)){
        foreach ($id_value as $lang => $lang_value) {
          // IF FORMATS
          if (is_array($lang_value)){

            foreach ($lang_value as $formats => $formats_value) {

              if (!is_int($formats) || $formats != "default") {
                $formats_list = explode(" ", $formats);

                foreach ($formats_list as $format => $format_value) {
                  $normalizedArray[strtolower($id)][$lang][$format_value] = $id_value[$lang][$formats];
                }
              } else {
                $normalizedArray[strtolower($id)][$lang]["default"] = $id_value[$lang][0];
              }

            }
          }
        }
      }

		}
		return $normalizedArray;
	}


	private function GetCopy($id) {
		$normalizedId = strtolower($id);
		if (!isset($this->copies[$normalizedId])){
			throw new Exception("Copy '$id' undefined");
    }else{

      $isset_key = isset($this->copies[$normalizedId][$this->language]);

      if ($isset_key) {
        $search_array = $this->copies[$normalizedId][$this->language];
        if (array_key_exists($this->format, $search_array)) {
          return $this->copies[$normalizedId][$this->language][$this->format];
        } else {
          return $this->copies[$normalizedId][$this->language]['default'];
        }
      }

      throw new Exception("Copy '$id' not found for the current language : ".$this->language);
    }
	}

	private function FormatCopy($id, $copy, $DOMWrapper = null, $dataPrefix = "", $dataSuffix = "") {
		if (!isset($DOMWrapper))
			$DOMWrapper = $this->DOMWrapper;
		return !isset($DOMWrapper) ? $copy : '<'.$DOMWrapper.' id="'.$id.'" class="txt">'.$dataPrefix.$copy.$dataSuffix.'</'.$DOMWrapper.'>';
	}
}
