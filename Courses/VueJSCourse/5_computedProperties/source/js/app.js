new Vue({

    el: '#demo',
    data: {
        points: 100
    },
    computed: {
        skill: function() {
            if (this.points <= 100) {
                return "Beginner";
            }
            if (this.points <= 500) {
                return "Intermediate";
            }
            if (this.points > 500) {
                return "Advanced";
            }
        }
    }
});
