//exercise one
// Vue.filter("reverse", function(value, wordsOnly) {
//     var separator = wordsOnly ? " " : "";
//     return value.split(separator).reverse().join(separator);
// });
// new Vue({
//
//     el: '#demo',
//     data: {
//         message: "Hello, World!"
//     }
// });
//
// new Vue({
//
//     el: '#demo2',
//     data: {
//         message: "Hello Again"
//     },
//
//     filters: {
//         reverse: function(value, wordsOnly) {
//             var separator = wordsOnly ? " " : "";
//             return value.split(separator).reverse().join(separator);
//         }
//     }
// });

//exercise 2

new Vue({
    el: "#demo3",
    data: {
        gender: "all",
        people: [{
            name: "Eldon",
            gender: "male"
        }, {
            name: "Elroy",
            gender: "male"
        }, {
            name: "Augustus",
            gender: "male"
        }, {
            name: "Earnest",
            gender: "male"
        }, {
            name: "Sherman",
            gender: "male"
        }, {
            name: "Rudolph",
            gender: "male"
        }, {
            name: "Kizzie",
            gender: "female"
        }, {
            name: "Yuriko",
            gender: "female"
        }, {
            name: "Tandra",
            gender: "female"
        }, {
            name: "Tiffiny",
            gender: "female"
        }]
    },
    filters: {
        gender: function(people) {
            if (this.gender === "all") {
                return people;
            }
            return people.filter(function(person) {

                return person.gender === this.gender;
            }.bind(this));
        }
    }
});
