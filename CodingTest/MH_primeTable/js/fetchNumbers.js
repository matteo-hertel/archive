/*
 * This JS worker gets a JSON object from the main script and will create and populate
 * an array that virtually represent the table
 * 
 * Why use a worker?
 * 
 * So far the fetch of the prime numbers from a text file is easy and straightforward
 * but, with the right mathematical knowledge in this worker can be implemented an alghoritm
 * that will found thousand of prime numbers, heavy computation can freeze the browser so doing it in a worker
 * will return the result and the browser will not freeze  
 * 
 */

self.addEventListener("message", function(e) {
    //init some variables
    var file = e.data, number, len, i, out;
    //new AJAX object
    xhr = new XMLHttpRequest();
    //fetch the file
    xhr.open('GET', file, true);
    xhr.setRequestHeader('Content-Type', 'text/plain');
    xhr.onload = function(e) {
        if (this.status == 200) {
            // once the file is fetched all the unwanted char will be stripped and the plain text will be splitted into an array
            text = this.response.replace(/(\r\n|\n|\r)/gm, "").replace(/  +/g, ',').split(",");

            out = [];
            len = text.length;
            // just to be sure loop through the array and insert in the output only the valid values
            for (i = 0; i < len; i++) {
                if (text[i]) {
                    out.push(text[i]);
                }
            }
            // return the output
            postMessage(out)
        }

    }
    xhr.send();
}, false);