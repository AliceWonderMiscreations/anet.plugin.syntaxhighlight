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
