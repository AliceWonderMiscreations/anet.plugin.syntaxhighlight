<?php
/*
WARNING: "pear/XML_Parser" is deprecated in favor of "pear/XML_Parser2"
WARNING: "pear/Console_Getopt" is deprecated in favor of "pear/Console_GetoptPlus"
*/


class anetSyntaxHighlight {

  private $dom;
  private $hlight = FALSE;
  private $THL_LANGS = array('ABAP', 'AVRC', 'CPP', 'CSS', 'DIFF', 'DTD', 'HTML', 'JAVA', 'JAVASCRIPT', 'MYSQL', 'PERL', 'PHP', 'PYTHON', 'RUBY', 'SH', 'SQL', 'VBSCRIPT', 'XML');
  
  private function codeString($code,$lang='TXT',$oneline=false) {
   $lang = strtoupper($lang);
   if(strcmp($lang, 'JS') == 0) {
     $lang = 'JAVASCRIPT';
   }
   if (in_array($lang,$this->THL_LANGS)) {
      //$dom->formatOutput = false;
      $hl =& Text_Highlighter::factory($lang);
      $out = $hl->highlight($code);
      $out = preg_replace("/<span class=\"hl-code\">\n/","\n<span class=\"hl-code\">",$out);
      $tmpDOM = new DOMDocument('1.0','UTF-8');
      $tmpDOM->loadXML($out);
      $divList = $tmpDOM->getElementsByTagName('div');
      $impDIV = $divList->item(0);
      $node = $this->dom->importNode($impDIV,true);
      } else {
      $node = $this->dom->createElement('div');
      $node->setAttribute('class','mono');
      $pre = $this->dom->createElement('pre',$code);
      $node->appendChild($pre);
      }
   return($node);
   }
   
   public function highlight ($pre) {
     if(! $this->hlight) {
       return TRUE;
     }
     if ($pre->hasAttribute('data-code')) {
       $oneline = FALSE;
       $lang = $pre->getAttribute('data-code');
       $code = trim($pre->nodeValue);
       $foo = split('\n', $code);
       $n=count($foo);
       if ($n == 1) {
         $oneline = TRUE;
       }
       $s  = array('/\&lt;/','/\&gt;/'); $r = array('<','>');
       $code = preg_replace($s, $r, $code);
       $newPre = $this->codeString($code, $lang, $oneline);
       $genPre = $newPre->getElementsByTagName('pre')->item(0);
       $genPre->setAttribute('data-code', $lang);
       $pre->parentNode->replaceChild($newPre, $pre);
     }
   }

  public function anetSyntaxHighlight($dom) {
    $this->dom = $dom;
    if (class_exists('Text_Highlighter')) {
      $this->hlight = TRUE;
    }
  }
}
?>
