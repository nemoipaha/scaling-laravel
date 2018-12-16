<template>
    <div class="panel-body">
        <button class="btn btn-success" @click.prevent="createJob" v-if="!tasks.length">
            <i class="glyphicon glyphicon-adjust"></i>
            Start long job
        </button>
        <button class="btn btn-success" v-else>
            <i class="glyphicon glyphicon-refresh rotate"></i>
            Job is processing
        </button>
    </div>
</template>

<script>
    export default {
        name: "process-job",

        data() {
            return {
                tasks: []
            };
        },

        mounted() {
            this.getTasks();
        },

        methods: {
            getTasks() {
                axios.get('/tasks')
                    .then(response => {
                        console.log(
                            'tasks fetch',
                            response
                        )

                        this.tasks = response.data;

                        _.each(this.tasks, (task) => {
                            this.createTaskCompletedListener(task.id);
                        });
                    });
            },

            createJob() {
                axios.post('/job')
                    .then((response) => {
                        this.tasks.push(response.data);
                        this.createTaskCompletedListener(response.data.id);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },

            createTaskCompletedListener(taskId) {
                Echo.private(`user.task.${taskId}`)
                    .listen('TaskCompleted', (e) => {
                        this.getTasks();
                    });
            }
        }
    }
</script>

<style scoped>

</style>