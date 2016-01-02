new Vue({

    el: '#demo',
    data: {
        character: [],
        error: false,
        count: 0,
        currentId: 0,
        loaded: false
    },
    ready: function() {
        this.fetchRandomCharacter();
    },
    methods: {
        fetchRandomCharacter: function() {
            this.loaded = false;
            if (this.count === 0) {
                this.getCount(this.fetchRandomCharacter);
                return;
            }
            this.getCharacter(this.generateRandomId(this.count));
        },
        getCount: function(callback) {
            this.$http.get('http://swapi.co/api/people/').then(function(response) {
                this.$set('count', response.data.count);
                if (typeof callback === "function") {
                    callback.bind(this)();
                }
            }, function(response) {

                this.error = true;
            }.bind(this));
        },
        generateRandomId: function(count) {
            return Math.floor(Math.random() * count) + 1;
        },
        getCharacter: function(id) {
            this.$http.get('http://swapi.co/api/people/' + id).then(function(response) {

                this.$set('character', response.data);
                this.$set('loaded', true);

            }, function(response) {

                this.error = true;
            }.bind(this));
        },
        formatDate: function(date) {
            if (!date) {
                return;
            }
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            var month = parseInt(date.getMonth()) + 1;
            return date.getDate() + "/" + month + "/" + date.getFullYear() + " " + strTime;
        }

    },
    filters: {
        userFriendly: function(string) {
            return string.replace("_", " ");
        },
        noUrl: function(obj) {
            var out = {};
            for (var i in obj) {

                if (typeof obj[i] === "string" && obj[i].indexOf("http") === -1) {
                    out[i] = obj[i];
                }
            }
            return out;
        },
        date: function(obj) {
            for (var i in obj) {

                if (i === "created" || i === "edited") {
                    obj[i] = this.formatDate(new Date(obj[i]));
                }
            }
            return obj;
        }
    }
});
