/*jslint browser: true, plusplus: true, regexp: true */

function lineBreakCount(str) {
    "use strict";
    // http://snippets.dzone.com/posts/show/5770
    /* counts \n */
    try {
        return ((str.match(/[^\n]*\n[^\n]*/gi).length));
    } catch (e) {
        return 0;
    }
}

function nodeToCopy(node) {
    "use strict";
    var n, string, pre;
    pre = $(node).find('pre:first');
    string = $(pre).text();
    if (window.clipboardData && window.clipboardData.setData) {
        window.clipboardData.setData('text', string.replace(/\n/g, "\r\n"));
    } else {
        n = 1 + lineBreakCount(string);
        $(pre).attr('class', 'nodisplay');
        $(pre).after('<textarea readonly="readonly" rows="' + n + '" class="copycode">' + string.replace(/&/, '&amp;').replace(/</g, '&lt;').replace(/>/, '&gt;') + '</textarea>');
        $(node).find('textarea:first').focus();
        $(node).find('textarea:first').select();
        $(node).find('div:last').find('button').replaceWith('<button class="copycode" type="button">Restore</button>');
        $(node).find('div:last').find('button').click(function () {restorePreFromText($(this).parent().parent()); });
    }
}
// expected space
function restorePreFromText(node) {
    "use strict";
    $(node).find('pre:first').removeAttr('class');
    $(node).find('textarea').remove();
    $(node).find('div:last').find('button').replaceWith('<button class="copycode" type="button">Select Code</button>');
    $(node).find('div:last').find('button').click(function () {nodeToCopy($(this).parent().parent()); });
}

function codeSelectCopy() {
    "use strict";
    var copybutton;
    copybutton = 'Select Code';
    if (window.clipboardData && window.clipboardData.setData) {
        copybutton = 'Copy Code';
    }
    $('pre[data-code]').after('<div class="rbutton"><button class="copycode" type="button">' + copybutton + '</button></div>');
    $('button.copycode').click(function () {nodeToCopy($(this).parent().parent()); });
}

$(document).ready(function () {
    "use strict";
    codeSelectCopy();
});