anet.plugin.syntaxhighlight
===========================

This plugin provides server-side syntax highlighting for code that is wrapped
inside of a `<pre>` block.

Requirements
------------

This plugin depends upon the PEAR module Text_Highlighter. Some features will
work without that module, but the actual color syntax highlighting will not.

To install the needed PEAR module, as the root user issue the following
command:

`pear install Text_Highlighter-beta`

Supported Coding Languages
--------------------------

Syntax for the following languages are currently supported:

+ ABAP
+ AVRC
+ CPP
+ CSS
+ DIFF
+ DTD
+ HTML
+ JAVA
+ JAVASCRIPT
+ MYSQL
+ PERL
+ PHP
+ PYTHON
+ SH
+ SQL
+ VBSCRIPT
+ XML

Marking Code for Syntax Highlight
---------------------------------

To invoke syntax highlighting in the language of your code, indicate the
language of the code with the `data-code` code attribute in the `<pre>` block.

For example:

    <pre data-code="sh">
    #!/bin/bash
    echo "Hello World"
    sleep 5
    echo "Goodbye"
    exit
    </pre>
    
The plugin will trigger off of the `data-code` attribute, invoke `SH` for the
syntax highlight rules, and add the appropriate markup inside the `<pre>`
block.

Additional Features
-------------------

Code that is rendered in HTML can sometimes be a royal pain in the arse to copy
into the clipboard.

This plugin includes JavaScript that will create an HTML button to make things
easier for those who wish to copy the code into the clipboard.

When the button is pushed, the code is stripped of its color syntax and is
placed inside a `textarea` element as plain text. The entire block is selected
for the user, so all the user has to do is copy it.

When the button is clicked again, the original syntax highlighting is restored.

Known Issues
------------

### PHP

It seems that for PHP code snippets, the `Text_Highlighter` class used by this
plugin requires the starting `<?php` and closing `?>` in order to properly
apply the syntax highlighting.

### Text_Highlighter

There is currently not a PEAR maintainer for the Text_Highlighter module. It is
possible that an upgrade to PHP could break the class, and there might not be
someone to fix it.

I *suspect* that it will continue to work through all updates of the PHP 5.6.x
series but it is impossible for me to speculate beyond that.

### XML_Parser

The `Text_Highlighter` modules uses the PEAR `XML_Parser` module, which has
depricated.

It needs to be ported to use `XML_Parser2` instead. I am looking into it, if it
is simple enough of a task, I may port it and provide a patch to the PEAR QA
team which *may* then merge the patch into the source even though there is not
currently a maintainer.

That may give the module a longer life until a new maintainer can be found.

### DOMDocument formatOutput

If the DOMDocument object has output formatting turned on, the display of some
code blocks is broken.

I believe this is a bug in either libxml2 or in DOMDocument, it should not be
altering the format of anything inside a `<pre>` block for XHTML documents.

There may be a workaround that works, but for the present, this plugin will
unfortunately turn off the `formatOutput` option on the DOMDocument object that
AliceNet uses to construct the XHTML sent to the web browsers.
