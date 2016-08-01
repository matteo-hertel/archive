new Vue({

    el: '#demo',
    data: {
        plans: [{
            name: "Enterprise",
            price: 100
        }, {
            name: "Pro",
            price: 50
        }, {
            name: "Personal",
            price: 10
        }, {
            name: "Free",
            price: 0
        }],
        active: {}
    },
    components: {
        plan: {
            template: "#planTempalte",
            props: ["plan", "active"],
            methods: {
                setActivePlan: function() {
                    this.active = this.plan;
                }
            },
            computed: {
                isUpgrade: function() {
                    return this.plan.price > this.active.price;
                }
            }
        }
    }
});
