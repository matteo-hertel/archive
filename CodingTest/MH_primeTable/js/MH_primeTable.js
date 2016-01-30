/**
 * MH_primeTable
 * 
 * This object will provide a set f functions to print a prime numbers table.
 * 
 * The main task is to create a table with prime numbers, we can potentially have n prime numbers,
 * now I don't have the mathematical knowledge to find prime numbers that non involves brute force calculation
 * and generally speaking using brute force is almost never the right way to do something, so I or mathematician friends
 * of http://primes.utm.edu published this really good txt http://primes.utm.edu/lists/small/1000.txt
 * in which are contained the forst 1000 prime numbers, now they browser don't allow to use it in an asycrounus request
 * so I have downloaded a local copy.
 * 
 * 
 * For this assigment are assumed:
 *  - HTML5 support
 *  - XMLHttpRequest support
 *  - Web Worker support
 * 
 * tested on:
 *  - Firefox 30.0
 *  - Safari 5.1.7 (issue in integer validator)
 *  - IE 11.09
 *  - Chrome 36.0.1985.84 beta-m
 * 
 *  Unit tests passed in every browser
 * 
 *  The main principle behind this app is KISSAA
 *  Keep It Simple, Stuoid And Awesome
 * 
 *  Thanks to 
 * 		HTML5 Boilerplate http://html5boilerplate.com/
 * 		Twitter Bootstrap http://getbootstrap.com/
 * 
 * for the HTML/CSS
 * 
 * @author Matteo Hertel
 * @email info@matteohertel.com
 * @version 0.1
 * @license MIT@
 */

var MH_primeTable = {
    fire: function(config) {    // bootstrap method
        this.config = config;   // make the config available to all the components
        this.init();			// some check for the element passed in the config
        this.getNumbers();      // fetch the prime numbers
    },
    /*
     * this function will check if the right nodes are in the DOM, if not the value will be null
     */
    init: function() {

        var self = MH_primeTable;


        self.config.input = self.config.input ? document.getElementById(self.config.input) : null;
        self.config.output = self.config.output ? document.getElementById(self.config.output) : null;
        self.config.outputChild = self.config.outputChild ? document.getElementById(self.config.outputChild) : null;
        self.config.error = self.config.error ? document.getElementById(self.config.error) : null;
        self.config.errorMessage = self.config.errorMessage ? document.getElementById(self.config.errorMessage) : null;
    },
    /*
     *  This function will bind the keyup event and after 400ms since the user stopped to type
     * will lauch the eventFunction
     */
    bindEvents: function() {
        //init some variables
        var self = MH_primeTable, input;

        // proceed only if the input field is a valid node
        if (self.config.input) {
            //create a timeout var in the config object
            self.config.timeout;
            //bind the keyup
            self.config.input.addEventListener('keyup', function() {
                clearTimeout(self.config.timeout);
                //lauch the function
                self.config.timeout = setTimeout(self.eventFunction, 400);
            }, false);
        }
    },
    /*
     * This function fired by the event will validate the user input, display a proper message if invalid
     * enforce the limit and call the function to build the table
     */
    eventFunction: function() {
        //init some variables
        var self = MH_primeTable, val;
        val = self.config.input.value;

        if (self.validation(val)) {
            //if is valid and the error node is valid remove all previus error messages
            if (self.config.error) {
                self.config.error.classList.remove("has-error");
                self.config.errorMessage.textContent = "";
            }
            // if the value is greater than the limit display the limit message and stop the function
            if (val > self.config.limit) {
                self.limit(val);
                return;
            }
            // clear the timeout
            clearTimeout(self.config.timeout);
            // set the input field to read only during the computation
            self.config.input.readOnly = true;
            // build the table!
            self.buildTable(parseInt(val));
        } else {
            // add an error if the value is not an integer
            self.config.error.classList.add("has-error");
            self.config.errorMessage.textContent = "Try to use integers :)";
        }
    },
    /*
     * basic regular expression to check if the value is an integer
     */
    validation: function(val) {
        var regEx = new RegExp('^[0-9]+$');
        return regEx.test(val);
    },
    /*
     * friendly message if the user inserted a value greater that the limit
     */
    limit: function(val) {
        var self = MH_primeTable, notice;
        if (self.config.outputChild) {
            notice = document.createElement("h3");
            self.config.outputChild.textContent = "";
            	if (val > self.config.numbers.length){
                notice.textContent = "I'm sorry I have only " + self.config.numbers.length + " prime numbers in my memory, try another number";
   
                }else{
            notice.textContent = "I'm sorry but the limit to draw the table  is " + self.config.limit + ". The prime number #" + val + " is: " + self.config.numbers[val-1];
                }
            self.config.outputChild.appendChild(notice);

            self.config.input.readOnly = false;
        }
    },
    /*
     * fetch the number from the worker and make the result availabe to all the components
     */
    getNumbers: function() {
        var self = MH_primeTable, worker;
        //new Worker
        worker = new Worker("js/fetchNumbers.js");
        // send params to the worker
        worker.postMessage(self.config.file);
        // once the worker sends the result back
        worker.onmessage = function(event) {
            self.config.numbers = event.data;
            self.config.maxLimit = self.config.numbers.length;
            self.bindEvents();
            // by default a table of 10 is displayed to the user
            self.buildTable(10);
            //bind the events
            self.bindEvents();
        };


    },
    /*
     * build the virtual table (an array)
     */
    buildTable: function(num) {
        //init some variables
        var self = MH_primeTable, worker;
        //new worker
        worker = new Worker("js/buildTable.js");
        // send params to the worker
        worker.postMessage({"limit": num, "numbers": self.config.numbers});
        // once the worker sends the result back
        worker.onmessage = function(event) {
            self.config.virtualTable = event.data;
            self.printTable();
        };
    },
    /*
     * this function will create the HTML table from the array virtualTable
     * 
     * please note:
     * I'm using the document.create so every element is a real HTML node and not just text
     * if the length of the array is more that 100 (arbitrary number) the code will ask to the user
     * the confirmation to create the table warning him/her that the process can freeze the browser
     * 
     * Why I didn't use a worker?
     * The javascript worker has no access to the DOM so I can't create real DOM node in the worker
     * I could print the raw HTML but is not as powerful as the documnet.create
     */
    printTable: function() {
        //init some variables
        var self = MH_primeTable, table, tbody, tr, td, i, j, len = self.config.virtualTable.length, sure;
        // check for the output child node
        if (self.config.outputChild) {
            self.config.outputChild.textContent = "";
        }
        // confirm if the limit is more than 100
        if (len > 100) {
            sure = confirm("The generation of the table can take a lot of time and the screen my freen for few minutes, are you sure you want to see this talbe?");
            if (!sure) {
                self.config.input.readOnly = false;
                return false;
            }
        }
        // create the table!
        table = document.createElement("table");
        table.border = 1;
        table.classList.add("table");
        table.classList.add("table-hover");
        tbody = document.createElement("tbody");
        for (i = 0; i < len; i++) {
            tr = document.createElement("tr");
            for (j = 0; j < self.config.virtualTable[i].length; j++) {
                td = document.createElement("td");
                td.textContent = self.config.virtualTable[i][j];
                td.classList.add("text-center");
                tr.appendChild(td);
            }
            tbody.appendChild(tr);
        }
        table.appendChild(tbody);
        /*
         * if the input and output node are there reset the input to accept values
         * and add the table to the output otherwise return the table
         */
        if (self.config.input) {
            self.config.input.readOnly = false;
        }
        if (self.config.outputChild) {
            self.config.outputChild.appendChild(table);
        } else {
            return table;
        }


    }

};
/*
 * Init the object!
 */
MH_primeTable.fire({
    // the limit is the width of the window / 60, 60 is an arbitrary 
    // number tha can be considered as the min width of the cell 
    limit: Math.floor(window.innerWidth / 60),
    // file location
    file: "../assets/1000.txt",
    //selectors
    input: "input",
    output: "output",
    outputChild: "outputChild",
    error: "error",
    errorMessage: "errorMessage"

});