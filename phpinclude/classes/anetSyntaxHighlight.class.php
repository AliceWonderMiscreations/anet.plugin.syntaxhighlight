<?php

class anetSyntaxHighlight {

  private $dom;
  private $hlight = FALSE; //default to no syntax highlight in case PEAR module not available
  private $THL_LANGS = array('ABAP', 'AVRC', 'CPP', 'CSS', 'DIFF', 'DTD', 'HTML', 'JAVA', 'JAVASCRIPT', 'MYSQL', 'PERL', 'PHP', 'PYTHON', 'RUBY', 'SH', 'SQL', 'VBSCRIPT', 'XML');
  
  /* applies syntax highlight to code string */
  private function codeString($code, $lang='TXT') {
   $lang = strtoupper($lang);
   if (strcmp($lang, 'JS') == 0) {
     $lang = 'JAVASCRIPT';
   }
   if (in_array($lang, $this->THL_LANGS)) {
      //$dom->formatOutput = false;
      $hl =& Text_Highlighter::factory($lang);
      $out = $hl->highlight($code);
      $out = preg_replace("/<span class=\"hl-code\">\n/","\n<span class=\"hl-code\">",$out);
      $tmpDOM = new DOMDocument('1.0','UTF-8');
      $tmpDOM->loadXML($out);
      $divList = $tmpDOM->getElementsByTagName('div');
      $impDIV = $divList->item(0);
      $node = $this->dom->importNode($impDIV, true);
    } else {
      $node = $this->dom->createElement('div');
      $node->setAttribute('class','mono');
      $pre = $this->dom->createElement('pre', $code);
      $node->appendChild($pre);
      }
   return($node);
   }
   
   /* returns false if pear module not available
      otherwise swaps original pre node with syntax highlight */
   public function highlight ($pre) {
     if (! $this->hlight) {
       return FALSE;
     }
     if ($pre->hasAttribute('data-code')) {
       $lang = $pre->getAttribute('data-code');
       $code = trim($pre->nodeValue);
       $s = array('/\&lt;/','/\&gt;/'); $r = array('<','>'); //note - test with &amp; &quot; &apos;
       $code = preg_replace($s, $r, $code);
       $newPre = $this->codeString($code, $lang);
       $genPre = $newPre->getElementsByTagName('pre')->item(0);
       $genPre->setAttribute('data-code', $lang);
       $pre->parentNode->replaceChild($newPre, $pre);
     }
   }

  /* constructor - $dom is DOMDocument object */
  public function anetSyntaxHighlight($dom) {
    $this->dom = $dom;
    if (class_exists('Text_Highlighter')) {
      $this->hlight = TRUE;
    }
  }
}
?>