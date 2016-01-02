new Vue({

    el: '#demo',
    data: {
        sortKey: "",
        search: "",
        reverse: false,
        columns: ["name", "age"],
        people: [{
            name: "Merri",
            age: 20
        }, {
            name: "Carroll ",
            age: 32
        }, {
            name: "Antonietta",
            age: 18
        }, {
            name: "Kendra",
            age: 24
        }, {
            name: "Shala",
            age: 48
        }, {
            name: "Carter",
            age: 69
        }, {
            name: "Pierre",
            age: 52
        }, {
            name: "Theresa",
            age: 21
        }, {
            name: "Genia",
            age: 65
        }, {
            name: "Detra",
            age: 83
        }, {
            name: "Romona",
            age: 71
        }, {
            name: "Drew",
            age: 29
        }, {
            name: "Marilyn",
            age: 98
        }, {
            name: "Hyun",
            age: 26
        }, {
            name: "Dalene",
            age: 48
        }, {
            name: "Bertha",
            age: 16
        }, {
            name: "Joy",
            age: 40
        }, {
            name: "Hoyt",
            age: 54
        }, {
            name: "Arden",
            age: 21
        }, {
            name: "Nilda",
            age: 80
        }]
    },

    methods: {

        sortBy: function(key) {

            this.reverse = (this.sortKey === key) ? !this.reverse : false;
            this.sortKey = key;
        }
    }
});
