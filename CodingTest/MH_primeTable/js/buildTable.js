/*
 * This JS worker gets a JSON object from the main script and will create and populate
 * an array that virtually represent the table
 * 
 * Why use a worker?
 * 
 * this code can potentially creare a really big array, so for
 * sake of modularity and extensibility the computation is moved 
 * to an another thread
 * 
 */
// once the main script send a message to the worker let's start the process
self.addEventListener("message", function(e) {

    //init some variables
    var i, j, k, temp = [], virtualTable = [];

    //using loops the array is created
    for (i = 0; i < e.data.limit; i++) {
        if (i === 0) {
            for (j = 0; j < e.data.limit; j++) {
                temp.push(parseInt(e.data.numbers[j]));
            }
            virtualTable.push(temp);
            temp = [];
        } else {
            for (j = 0; j < e.data.limit; j++) {
                if (j === 0) {
                    temp.push(parseInt(e.data.numbers[i]));
                } else {
                    temp.push(false);
                }
            }
            virtualTable.push(temp);
            temp = [];
        }
    }

    // once the array is ready to be populate loop through it one more time
    for (k in virtualTable) {
        for (i = 0; i < virtualTable[k].length; i++) {
            if (virtualTable[k][i] === false) {
                virtualTable[k][i] = parseInt(virtualTable[k][0]) * parseInt(virtualTable[0][i]);
            }
        }
    }
    // send the result back
    postMessage(virtualTable)
}, false);