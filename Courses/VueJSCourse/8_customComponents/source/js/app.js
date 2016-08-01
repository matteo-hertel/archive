new Vue({

    el: '#demo',
    data: {
        tasks: [{
            body: "Go to the store",
            completed: false
        }, {
            body: "Go to the bank",
            completed: false
        }, {
            body: "Go to the doctor",
            completed: true
        }, {
            body: "Go to to work",
            completed: false
        }]
    },
    components: {

        tasks: {
            template: "#taskList",
            props: ["tasks"],
            methods: {
                toggleComplete: function(task) {
                    task.completed = !task.completed;
                }
            }
        }
    }
});
