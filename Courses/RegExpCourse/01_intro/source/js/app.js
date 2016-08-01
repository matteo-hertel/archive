/* jslint esnext : true */
'use strict';

const output = (str, regex, target) => {
    target.innerHTML = str. replace(regex, str => `<span class="text-info">${str}</span>`);
};

var str = "Is this This?";
/**
 * There are two ways to create a regular expression in JS
 *
 * Flags:
 * g : global
 * i : case insensitive
 */

//Method 1 Constructor
var regex1 = new RegExp("is", "gi");

//Method 2 literal

var regex2 = /is/gi;

output(str, regex2, document.querySelector("pre"));

// console.log(regex1.test(str));
// console.log(regex2.test(str));
// console.log(regex2.exec(str));
// console.log(regex2.exec(str));
// console.log(regex2.exec(str));

// console.log(str.match(regex2));

// console.log(str.replace(regex1, str => "XX"));

// console.log(str.search(regex1));
