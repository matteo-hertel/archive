Vue.component("message", {
    template: '<input type="text" v-model="message" class="form-control" @keyup.enter="storeMessage">',
    data: function() {
        return {
            message: ""
        };
    },
    methods: {
        storeMessage: function() {
            console.log("sotoring", this.message);

            //this.$dispatch only goes up
            //this.$broadcast only goes down

            this.$dispatch("new-message", this.message);
            this.message = "";
        }
    }
});

new Vue({

    el: '#demo',
    data: {
        messages: []
    },
    methods: {
        explicitNewMessage: function(message) {
            console.log("Parent received (explicit)", message);
        }
    },
    events: {
        //subscribe to event in this.$dispatch
        "new-message": function(message) {
            console.log("Parent received (implicit)", message);
            this.messages.push(message);
        }
    }
});
