<?php 
$text = '';
$query = 'SELECT * FROM SITE_PAGES WHERE URL = :URL';				
$stmt = $bdd->prepare($query);
$stmt->execute(array(':URL' => $_SERVER['PHP_SELF']));
while ($row = $stmt->fetch()) {
	$text .= $row['CONTENU']; 
};

$params['content'] = $text;
$params['encoding'] = 'utf-8'; 

// 1-word keywords
$params['min_word_length'] = 4;  // min length of single words
$params['min_word_occur']  = 3;  // min occur of single words
// 2-word keyphrases
$params['min_2words_length']        = 4;  // min length of words for 2 word phrases; value 0 will DISABLE !!!
$params['min_2words_phrase_length'] = 10; // min length of 2 word phrases
$params['min_2words_phrase_occur']  = 3;  // min occur of 2 words phrase
// 3-word keyphrases
$params['min_3words_length']        = 4;  // min length of words for 3 word phrases; value 0 will DISABLE !!!
$params['min_3words_phrase_length'] = 12; // min length of 3 word phrases
$params['min_3words_phrase_occur']  = 2;  // min occur of 3 words phrase

$keyword = new colossal_mind_mb_keyword_gen($params);
$autoKeywords = $keyword->get_keywords();

 
return $autoKeywords;

 
class colossal_mind_mb_keyword_gen {

	//declare variables
	var $contents;
	var $encoding;
	var $lang;
	var $ignore; // array; languages to ignore

	// generated keywords
	var $keywords;

	// minimum word length for inclusion into the single word metakeys
	var $wordLengthMin;
	var $wordOccuredMin;

	// minimum word length for inclusion into the 2-word phrase metakeys
	var $word2WordPhraseLengthMin;
	var $phrase2WordLengthMinOccur;

	// minimum word length for inclusion into the 3-word phrase metakeys
	var $word3WordPhraseLengthMin;

	// minimum phrase length for inclusion into the 2-word phrase metakeys
	var $phrase2WordLengthMin;
	var $phrase3WordLengthMinOccur;

	// minimum phrase length for inclusion into the 3-word phrase metakeys
	var $phrase3WordLengthMin;


	//------------------------------------------------------------------

	function colossal_mind_mb_keyword_gen ($params) {

		// language or default language; if not defined
		if (!isset($params['lang'])) $this->lang = 'en_GB';
		else $this->lang = $params['lang']; // case sensitive

		// multibyte internal encoding
		if (!isset($params['encoding'])) $this->encoding = 'UTF-8';
		else $this->encoding = strtoupper($params['encoding']); // case insensitive
		mb_internal_encoding($this->encoding);

		// languages to ignore
		if (isset($params['ignore']) && is_array($params['ignore'])) $this->ignore = $params['ignore']; // array of language codes
		else $this->ignore = false;

		// clean up input string; break along punctuations; explode into array
		if ($this->ignore !== false && in_array($this->lang, $this->ignore)) $this->contents = false; // language to be ignored
		else $this->contents = $this->process_text($params['content']);

		// LOAD THE PARAMETERS AND DEFAULTS
		// single keyword
		if (isset($params['min_word_length'])) { // value 0 means disable
			$this->wordLengthMin  = $params['min_word_length'];
		} else {
			// if not set, use this default
			$this->wordLengthMin = 5;
		}

		if (isset($params['min_word_occur'])) {
			$this->wordOccuredMin = $params['min_word_occur'];
		} else {
			// if not set, use this default
			$this->wordOccuredMin = 3;
		}

		//--------------------------------------------------------------
		// 2-word keyphrase
		if (isset($params['min_2words_length']) && $params['min_2words_length'] == 0) { // value 0 means disable
			$this->word2WordPhraseLengthMin  = false;
		}
		elseif (isset($params['min_2words_length']) && $params['min_2words_length'] !== 0) {
			$this->word2WordPhraseLengthMin  = $params['min_2words_length'];
			$this->phrase2WordLengthMin      = $params['min_2words_phrase_length'];
			$this->phrase2WordLengthMinOccur = $params['min_2words_phrase_occur'];
		}
		else {
			// if not set, use these defaults
			$this->word2WordPhraseLengthMin  = 4;
			$this->phrase2WordLengthMin      = 8;
			$this->phrase2WordLengthMinOccur = 3;
		}

		//--------------------------------------------------------------
		// 3-word keyphrase
		if (isset($params['min_3words_length']) && $params['min_3words_length'] == 0) { // value 0 means disable
			$this->word3WordPhraseLengthMin  = false;
		}
		elseif (isset($params['min_3words_length']) && $params['min_3words_length'] !== 0) {
			$this->word3WordPhraseLengthMin  = $params['min_3words_length'];
			$this->phrase3WordLengthMin      = $params['min_3words_phrase_length'];
			$this->phrase3WordLengthMinOccur = $params['min_3words_phrase_occur'];
		}
		else {
			// if not set, use these defaults
			$this->word3WordPhraseLengthMin  = 4;
			$this->phrase3WordLengthMin      = 12;
			$this->phrase3WordLengthMinOccur = 3;
		}
		//--------------------------------------------------------------
	}

	//------------------------------------------------------------------

	function get_keywords () {

		if ($this->contents === false) return '';

		$onew_arr = $this->parse_words();

		$twow_arr = $this->parse_2words();

		$thrw_arr = $this->parse_3words();

		// remove 2-word phrases if same single words exist
		if ($onew_arr !== false && $twow_arr !== false) {
			$cnt = count($onew_arr);
			for ($i = 0; $i < $cnt-1; $i++) {
				foreach ($twow_arr as $key => $phrase) {
					if ($onew_arr[$i].' '.$onew_arr[$i+1] === $phrase) unset($twow_arr[$key]);
				}
			}
		}

		// remove 3-word phrases if same single words exist
		if ($onew_arr !== false && $thrw_arr !== false) {
			$cnt = count($onew_arr);
			for ($i = 0; $i < $cnt-2; $i++) {
				foreach ($thrw_arr as $key => $phrase) {
					if ($onew_arr[$i].' '.$onew_arr[$i+1].' '.$onew_arr[$i+2] === $phrase) unset($thrw_arr[$key]);
				}
			}
		}

		// remove duplicate ENGLISH plural words
		if (substr($this->lang, 0, 2) == 'en') {
			if ($onew_arr !== false) {
				$cnt = count($onew_arr);
				for ($i = 0; $i < $cnt-1; $i++) {
					for ($j = $i+1; $j < $cnt; $j++) {
						if (array_key_exists($i, $onew_arr) && array_key_exists($j, $onew_arr)) {
							if ($onew_arr[$i].'s' == $onew_arr[$j]) unset($onew_arr[$j]);
							if (array_key_exists($j, $onew_arr)) {
								if ($onew_arr[$i] == $onew_arr[$j].'s') unset($onew_arr[$i]);
							}
						}
					}
				}
			}
		}

		// ready for output - implode arrays
		if ($onew_arr !== false) $onew_kw = implode(',', $onew_arr) .',';
		else $onew_kw = '';

		if ($twow_arr !== false) $twow_kw = implode(',', $twow_arr) .',';
		else $twow_kw = '';

		if ($thrw_arr !== false) $thrw_kw = implode(',', $thrw_arr) .',';
		else $thrw_kw = '';

		$keywords = $onew_kw . $twow_kw . $thrw_kw;
		return rtrim($keywords, ',');
	}

	//------------------------------------------------------------------

	function process_text ($str) {

		if (preg_match('/^\s*$/', $str)) return false;

		// strip HTML
		$str = $this->html2txt($str);

		//convert all characters to lower case
		$str = mb_strtolower($str, $this->encoding);

		// some cleanup
		$str = ' '.$str .' '; // pad that is necessary
		$str = preg_replace('#\ [a-z]{1,2}\ #i', ' ', $str); // remove 2 letter words and numbers
		$str = preg_replace('#[0-9\,\.:]#', '', $str); // remove numerals, including commas and dots that are part of the numeral
		$str = preg_replace("/([a-z]{2,})('|’)s/", '\\1', $str); // remove only the 's (as in mother's)
		$str = str_replace('-', ' ', $str); // remove hyphens (-)

		// IGNORE WORDS LIST
		// add, remove, edit as needed
		// make sure that paths are correct and necessary files are uploaded to your server
		//require_once(dirname(__FILE__) .'/common-words-'.$this->lang.'.php');
		$common = array(
			/* Mots communs non utilisés - via http://members.unine.ch/jacques.savoy/clef/index.html */
			/* FRANCAIS */
			"a", "à", "â", "abord", "afin", "ah", "ai", "aie", "ainsi", "allaient", "allo", "allô", "allons", "après", "assez", "attendu", "au", "aucun", "aucune", "aujourd", "aujourd'hui", "auquel", "aura", "auront", "aussi", "autre", "autres", "aux", "auxquelles", "auxquels", "avaient", "avais", "avait", "avant", "avec", "avoir", "ayant", "b", "bah", "beaucoup", "bien", "bigre", "boum", "bravo", "brrr", "c", "ça", "car", "ce", "ceci", "cela", "celle", "celle-ci", "celle-là", "celles", "celles-ci", "celles-là", "celui", "celui-ci", "celui-là", "cent", "cependant", "certain", "certaine", "certaines", "certains", "certes", "ces", "cet", "cette", "ceux", "ceux-ci", "ceux-là", "chacun", "chaque", "cher", "chère", "chères", "chers", "chez", "chiche", "chut", "ci", "cinq", "cinquantaine", "cinquante", "cinquantième", "cinquième", "clac", "clic", "combien", "comme", "comment", "compris", "concernant", "contre", "couic", "crac", "d", "da", "dans", "de", "debout", "dedans", "dehors", "delà", "depuis", "derrière", "des", "dès", "désormais", "desquelles", "desquels", "dessous", "dessus", "deux", "deuxième", "deuxièmement", "devant", "devers", "devra", "différent", "différente", "différentes", "différents", "dire", "divers", "diverse", "diverses", "dix", "dix-huit", "dixième", "dix-neuf", "dix-sept", "doit", "doivent", "donc", "dont", "douze", "douzième", "dring", "du", "duquel", "durant", "e", "effet", "également", "eh", "elle", "elle-même", "elles", "elles-mêmes", "en", "encore", "entre", "envers", "environ", "es", "ès", "est", "et", "etant", "étaient", "étais", "était", "étant", "etc", "été", "etre", "être", "eu", "euh", "eux", "eux-mêmes", "excepté", "f", "façon", "fais", "faisaient", "faisant", "fait", "feront", "fi", "flac", "floc", "font", "g", "gens", "h", "ha", "hé", "hein", "hélas", "hem", "hep", "hi", "ho", "holà", "hop", "hormis", "hors", "hou", "houp", "hue", "hui", "huit", "huitième", "hum", "hurrah", "i", "il", "ils", "importe", "j", "je", "jusqu", "jusque", "k", "l", "la", "là", "laquelle", "las", "le", "lequel", "les", "lès", "lesquelles", "lesquels", "leur", "leurs", "longtemps", "lorsque", "lui", "lui-même", "m", "ma", "maint", "mais", "malgré", "me", "même", "mêmes", "merci", "mes", "mien", "mienne", "miennes", "miens", "mille", "mince", "moi", "moi-même", "moins", "mon", "moyennant", "n", "na", "ne", "néanmoins", "neuf", "neuvième", "ni", "nombreuses", "nombreux", "non", "nos", "notre", "nôtre", "nôtres", "nous", "nous-mêmes", "nul", "o", "o|", "ô", "oh", "ohé", "olé", "ollé", "on", "ont", "onze", "onzième", "ore", "ou", "où", "ouf", "ouias", "oust", "ouste", "outre", "p", "paf", "pan", "par", "parmi", "partant", "particulier", "particulière", "particulièrement", "pas", "passé", "pendant", "personne", "peu", "peut", "peuvent", "peux", "pff", "pfft", "pfut", "pif", "plein", "plouf", "plus", "plusieurs", "plutôt", "pouah", "pour", "pourquoi", "premier", "première", "premièrement", "près", "proche", "psitt", "puisque", "q", "qu", "quand", "quant", "quanta", "quant-à-soi", "quarante", "quatorze", "quatre", "quatre-vingt", "quatrième", "quatrièmement", "que", "quel", "quelconque", "quelle", "quelles", "quelque", "quelques", "quelqu'un", "quels", "qui", "quiconque", "quinze", "quoi", "quoique", "r", "revoici", "revoilà", "rien", "s", "sa", "sacrebleu", "sans", "sapristi", "sauf", "se", "seize", "selon", "sept", "septième", "sera", "seront", "ses", "si", "sien", "sienne", "siennes", "siens", "sinon", "six", "sixième", "soi", "soi-même", "soit", "soixante", "son", "sont", "sous", "stop", "suis", "suivant", "sur", "surtout", "t", "ta", "tac", "tant", "te", "té", "tel", "telle", "tellement", "telles", "tels", "tenant", "tes", "tic", "tien", "tienne", "tiennes", "tiens", "toc", "toi", "toi-même", "ton", "touchant", "toujours", "tous", "tout", "toute", "toutes", "treize", "trente", "très", "trois", "troisième", "troisièmement", "trop", "tsoin", "tsouin", "tu", "u", "un", "une", "unes", "uns", "v", "va", "vais", "vas", "vé", "vers", "via", "vif", "vifs", "vingt", "vivat", "vive", "vives", "vlan", "voici", "voilà", "vont", "vos", "votre", "vôtre", "vôtres", "vous", "vous-mêmes", "vu", "w", "x", "y", "z", "zut");
		if (isset($common)) {
			foreach ($common as $word) $str = str_replace(' '.$word.' ', ' ', $str);
			unset($common);
		}

		// replace multiple whitespaces
		$str = preg_replace('/\s\s+/', ' ', $str);
		$str = trim($str);

		if (preg_match('/^\s*$/', $str)) return false;

		// WORD SEGMENTATION
		// break along paragraphs, punctuations
		$arrA = explode("\n", $str);
		foreach ($arrA as $key => $value) {
			if (strpos($value, '.') !== false) $arrB[$key] = explode('.', $value);
			else $arrB[$key] = $value;
		}
		$arrB = $this->array_flatten($arrB);
		unset($arrA);
		foreach ($arrB as $key => $value) {
			if (strpos($value, '!') !== false) $arrC[$key] = explode('!', $value);
			else $arrC[$key] = $value;
		}
		$arrC = $this->array_flatten($arrC);
		unset($arrB);
		foreach ($arrC as $key => $value) {
			if (strpos($value, '?') !== false) $arrD[$key] = explode('?', $value);
			else $arrD[$key] = $value;
		}
		$arrD = $this->array_flatten($arrD);
		unset($arrC);
		foreach ($arrD as $key => $value) {
			if (strpos($value, ',') !== false) $arrE[$key] = explode(',', $value);
			else $arrE[$key] = $value;
		}
		$arrE = $this->array_flatten($arrE);
		unset($arrD);
		foreach ($arrE as $key => $value) {
			if (strpos($value, ';') !== false) $arrF[$key] = explode(';', $value);
			else $arrF[$key] = $value;
		}
		$arrF = $this->array_flatten($arrF);
		unset($arrE);
		foreach ($arrF as $key => $value) {
			if (strpos($value, ':') !== false) $arrG[$key] = explode(':', $value);
			else $arrG[$key] = $value;
		}
		$arrG = $this->array_flatten($arrG);
		unset($arrF);
		//--------------------------------------------------------------

		return $arrG;
	}

	//single words
	function parse_words () {

		if ($this->wordLengthMin === 0) return false; // 0 means disable

		$str = implode(' ', $this->contents);
		$str = $this->strip_punctuations($str);

		// create an array out of the site contents
		$s = explode(' ', $str);

		// iterate inside the array
		foreach($s as $key => $val) {
			if (mb_strlen($val, $this->encoding) >= $this->wordLengthMin) $k[] = $val;
		}

		if (!isset($k)) return false;

		// count the words; this is the real magic!
		$k = array_count_values($k);

		return $this->occure_filter($k, $this->wordOccuredMin);
	}

	// 2-word phrases
	function parse_2words () {

		if ($this->word2WordPhraseLengthMin === false) return false; // 0 means disable

		foreach ($this->contents as $key => $str) {
			$str = $this->strip_punctuations($str);
			$arr[$key] = explode(' ', $str); // 2-dimensional array
		}

		$z = 0; // key of the 2-word array
		$lines = count($arr);
		for ($a = 0; $a < $lines; $a++) {
			$words = count($arr[$a]);
			for ($i = 0; $i < $words-1; $i++) {
				if ((mb_strlen($arr[$a][$i], $this->encoding) >= $this->word2WordPhraseLengthMin) && (mb_strlen($arr[$a][$i+1], $this->encoding) >= $this->word2WordPhraseLengthMin)) {
					$y[$z] = $arr[$a][$i] ." ". $arr[$a][$i+1];
					$z++;
				}
			}
		}

		if (!isset($y)) return false;

		// count the words; this is the real magic!
		$y = array_count_values($y);

		return $this->occure_filter($y, $this->phrase2WordLengthMinOccur);
	}

	// 3-word phrases
	function parse_3words () {

		if ($this->word3WordPhraseLengthMin === false) return false; // 0 means disable

		foreach ($this->contents as $key => $str) {
			$str = $this->strip_punctuations($str);
			$arr[$key] = explode(' ', $str); // 2-dimensional array
		}

		$z = 0; // key of the 3-word array
		$lines = count($arr);
		for ($a = 0; $a < $lines; $a++) {
			$words = count($arr[$a]);
			for ($i = 0; $i < $words-2; $i++) {
				if ((mb_strlen($arr[$a][$i], $this->encoding) >= $this->word3WordPhraseLengthMin) && (mb_strlen($arr[$a][$i+1], $this->encoding) >= $this->word3WordPhraseLengthMin) && (mb_strlen($arr[$a][$i+2], $this->encoding) >= $this->word3WordPhraseLengthMin)) {
					$y[$z] = $arr[$a][$i] ." ". $arr[$a][$i+1] ." ". $arr[$a][$i+2];
					$z++;
				}
			}
		}

		if (!isset($y)) return false;

		// count the words; this is the real magic!
		$y = array_count_values($y);

		return $this->occure_filter($y, $this->phrase3WordLengthMinOccur);
	}

	//------------------------------------------------------------------

	function occure_filter ($array, $min) {
		$cnt = 0;
		foreach ($array as $word => $occured) {
			if ($occured >= $min) {
				$new[$cnt] = $word;
				$cnt++;
			}
		}
		if (isset($new)) return $new;
		return false;
	}

	//------------------------------------------------------------------
	// converts any-dimensional to 1-dimensional array
	function array_flatten($array, $flat = false) {
		if (!is_array($array) || empty($array)) return '';
		if (empty($flat)) $flat = array();

		foreach ($array as $key => $val) {
			if (is_array($val)) $flat = $this->array_flatten($val, $flat);
			else $flat[] = $val;
		}

		return $flat;
	}

	//------------------------------------------------------------------

	function html2txt ($str) {
		if ($str == '') return '';
		$str = preg_replace("#<script.*?>[\s\S]*<\/script>#i", "", $str); // removes JavaScript
		$str = preg_replace("#(</p>\s*<p>|</div>\s*<div>|</li>\s*<li>|</td>\s*<td>|<br>|<br\ ?/>)#i", "\n", $str); // we use \n to segment words
		$str = preg_replace("#(\n){2,}#", "\n", $str); // replace multiple with single line breaks
		$str = strip_tags($str);
		$unwanted = array('"', '“', '„', '<', '>', '/', '*', '[', ']', '+', '=', '#');
		$str = str_replace($unwanted, ' ', $str);
		$str = preg_replace('/&nbsp;/i', ' ', $str); // remove &nbsp;
		$str = preg_replace('/&[a-z]{2,5};/i', '', $str); // remove &trade;  &copy;
		$str = preg_replace('/\s\s+/', ' ', $str); // replace multiple white spaces
		return trim($str);
	}

	//------------------------------------------------------------------

	function strip_punctuations ($str) {
		if ($str == '') return '';
		// edit as needed
		$punctuations = array('"',"'",'’','˝','„','`','.',',',';',':','+','±','-','_','=','(',')','[',']','<','>','{','}','/','\\','|','?','!','@','#','%','^','&','§','$','¢','£','€','¥','₣','฿','*','~','。','，','、','；','：','？','！','…','—','·','ˉ','ˇ','¨','‘','’','“','”','々','～','‖','∶','＂','＇','｀','｜','〃','〔','〕','〈','〉','《','》','「','」','『','』','．','〖','〗','【','】','（','）','［','］','｛','｝','／','“','”');
		$str = str_replace($punctuations, ' ', $str);
		return preg_replace('/\s\s+/', ' ', $str);
	}

	//------------------------------------------------------------------

	function remove_duplicate_keywords($str) {
		if ($str == '') return $str;
		$str = trim(mb_strtolower($str));
		$kw_arr = explode(',', $str); // array
		foreach ($kw_arr as $key => $val) {
			$kw_arr[$key] = trim($val);
			if ($kw_arr[$key] == '') unset($kw_arr[$key]);
		}
		$kw_arr = array_unique($kw_arr);
		// remove duplicate ENGLISH plural words
		if (substr($this->lang, 0, 2) == 'en') {
			$cnt = count($kw_arr);
			for ($i = 0; $i < $cnt; $i++) {
				for ($j = $i+1; $j < $cnt; $j++) {
					if (array_key_exists($i, $kw_arr) && array_key_exists($j, $kw_arr)) {
						if ($kw_arr[$i].'s' == $kw_arr[$j]) unset($kw_arr[$j]);
						elseif ($kw_arr[$i] == $kw_arr[$j].'s') unset($kw_arr[$i]);
						//--------------
						elseif (preg_match('#ss$#', $kw_arr[$j])) {
							if ($kw_arr[$i] === $kw_arr[$j].'es') unset($kw_arr[$i]); // addresses VS address
						}
						elseif (preg_match('#ss$#', $kw_arr[$i])) {
							if ($kw_arr[$i].'es' === $kw_arr[$j]) unset($kw_arr[$j]); // address VS addresses
						}
						//---------------
					}
					$kw_arr = array_values($kw_arr);
				}
				$kw_arr = array_values($kw_arr);
			}
		}
		// job is done!
		return implode(',', $kw_arr);
	}

	//------------------------------------------------------------------
}
//----------------------------------------------------------------------

