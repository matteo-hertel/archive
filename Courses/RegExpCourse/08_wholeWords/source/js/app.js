/* global document */
/* jslint esnext : true */
(function() {
    'use strict';

    var str = `This island is his, it is`;
    /**
     * \b is word boundaries
     */
    var regex = /is\B/g;

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
