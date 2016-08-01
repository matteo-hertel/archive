/* jslint esnext : true */
'use strict';

var str = `
http://egghead.io
not a webaddress here
http://
https://egghead.io
`;

var regex = /https?:\/\/.+/g;


/**
 * @param String str
 * @param RegExp regex
 * @param HTMLElement target
 */
const output = (str, regex, target) => {
    target.innerHTML = str. replace(regex, str => `<span class="text-info">${str}</span>`);
};

output(str, regex, document.querySelector("pre"));
