/* global document */
/* jslint esnext : true */
(function() {
    'use strict';

    // var str = `it was the the thing thing`;
    // var regex = /(\w+)\s?(?=\1)/g;

    var str = `<b>Bold</b><i>Italics</i>`;

    var regex = /<(\w+)>(.*)<\/\1>/g;

    console.log(str.replace(regex, "$2\n"));
    /**
     * @param String str
     * @param RegExp regex
     * @param HTMLElement target
     */
    const output = (str, regex, target) => {
        target.innerHTML = str.replace(regex, str => `<span class="text-info">${str}</span>`);
    };

    output(str, regex, document.querySelector("pre"));
})();
