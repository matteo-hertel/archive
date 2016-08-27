new Vue({

    el: '#demo',
    data: {

    },
    components: {

        alert: {
            template: "#alert",
            data: function() {
                return {
                    show: true
                };
            },
            props: {
                type: {
                    default: "info"
                },
                timeout: {
                    default: 3000
                },
                important: {
                    type: Boolean,
                    default: false
                },
            },
            methods: {
                toggleShow : function(){
                    this.show = !this.show;
                }
            },
            ready: function() {
                if (this.important) {
                    return;
                }

                setTimeout(function() {
                    this.show = false;
                }.bind(this), this.timeout);
            }
        }
    }
});
