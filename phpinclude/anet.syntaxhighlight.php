<?php

/* pear */
@include_once('Text/Highlighter.php');

$n=0;
$sh = new anetSyntaxHighlight($dom);
$prelist = $dom->getElementsByTagName('pre');
for ($j = $prelist->length; --$j >= 0; ) {
  $pre = $prelist->item($j);
  if($pre->hasAttribute('data-code')) {
    $n++;
    $sh->highlight($pre);
  }
}
if($n > 0) {
  $dom->formatOutput = FALSE;
  $scriptManager->addScript('syntaxHighlight.js', 'anet.plugin.syntaxhighlight');
  $scriptManager->addStyle('syntaxHighlight.css', 'anet.plugin.syntaxhighlight');
}

?>