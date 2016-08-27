/* global document */
/* jslint esnext : true */
(function() {
    'use strict';
    var str = `17/01/2016
17-01-2013
11/17/16
17/17/2016`;

    //var regex = /(\d{1,2})\/(\d{1,2})\/(\d{1,4})/g;
    var regex = /^17.+16$/gm;

    console.log(regex.exec(str));
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
