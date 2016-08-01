Vue.filter("jsonIt", function(value) {
    return JSON.stringify(value);
});

Vue.filter("gender", function(value, gender) {
    if (!gender) {
        return value;
    }
    return value.filter(function(i) {
        return i.gender === gender;
    });
});
new Vue({

    el: '#demo',
    data: {
        filter: "",
        //thanks https://www.mockaroo.com/ for the data
        people: [{
            "id": 1,
            "gender": "Female",
            "first_name": "Sandra",
            "last_name": "Butler",
            "email": "sbutler0@de.vu",
            "ip_address": "4.66.142.89"
        }, {
            "id": 2,
            "gender": "Male",
            "first_name": "Anthony",
            "last_name": "Cunningham",
            "email": "acunningham1@java.com",
            "ip_address": "84.146.201.70"
        }, {
            "id": 3,
            "gender": "Female",
            "first_name": "Mary",
            "last_name": "Lawson",
            "email": "mlawson2@gnu.org",
            "ip_address": "99.32.134.77"
        }, {
            "id": 4,
            "gender": "Female",
            "first_name": "Phyllis",
            "last_name": "Lawrence",
            "email": "plawrence3@behance.net",
            "ip_address": "143.131.152.17"
        }, {
            "id": 5,
            "gender": "Male",
            "first_name": "Ernest",
            "last_name": "Morris",
            "email": "emorris4@reuters.com",
            "ip_address": "88.101.139.150"
        }, {
            "id": 6,
            "gender": "Female",
            "first_name": "Virginia",
            "last_name": "Martin",
            "email": "vmartin5@nyu.edu",
            "ip_address": "195.149.219.30"
        }, {
            "id": 7,
            "gender": "Male",
            "first_name": "Ryan",
            "last_name": "Griffin",
            "email": "rgriffin6@twitter.com",
            "ip_address": "225.185.120.144"
        }, {
            "id": 8,
            "gender": "Female",
            "first_name": "Maria",
            "last_name": "Montgomery",
            "email": "mmontgomery7@hugedomains.com",
            "ip_address": "182.128.247.23"
        }, {
            "id": 9,
            "gender": "Female",
            "first_name": "Rebecca",
            "last_name": "Alvarez",
            "email": "ralvarez8@fastcompany.com",
            "ip_address": "214.123.142.6"
        }, {
            "id": 10,
            "gender": "Female",
            "first_name": "Alice",
            "last_name": "Burke",
            "email": "aburke9@weebly.com",
            "ip_address": "171.116.163.20"
        }]
    },
    methods: {
        fullName: function(person) {
            return person.first_name + " " + person.last_name;
        },
        setFilter: function(filter) {
            this.filter = filter;
        }
    }
});
