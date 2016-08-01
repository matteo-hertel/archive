/* global document */
/* jslint esnext : true */
(function() {
    'use strict';

    var str = `Aeiou $100 55.5%`;

    /**
     * Shorthands
     * \w all lowercase letters all uppercase letter and all digits
     * \d all digits
     * \s white spaces
     * \W negate version of \w
     * \D negate version of \d
     * \S negate version of \s
     * ^ negate a character class
     */

    var regex = /\w/g;


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
