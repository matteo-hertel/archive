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
                },
                isCompleted: function(task) {
                    return task.completed;
                },
                inProgress: function(task) {
                    return !task.completed;
                },
                removeTask: function(task) {
                    this.tasks.$remove(task);
                },
                clearCompleted: function() {
                    this.tasks = this.tasks.filter(this.inProgress);
                }
            },
            computed: {
                remaining: function() {
                    return this.tasks.filter(this.inProgress).length;
                }
            }
        }
    }
});
