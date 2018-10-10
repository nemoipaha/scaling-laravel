<template>
    <div class="panel-body">
        <button class="btn btn-success" @click.prevent="createJob" v-if="!processing">
            <i class="glyphicon glyphicon-adjust"></i>
            Start long job
        </button>
        <button class="btn btn-success" v-else>
            <i class="glyphicon glyphicon-refresh rotate"></i>
            Kick off long job
        </button>
    </div>
</template>

<script>
    export default {
        name: "process-job",

        data() {
            return {
                processing: false,
                task_id: undefined
            };
        },

        methods: {
            createJob() {
                axios.post('/job')
                    .then((response) => {
                        this.processing = true;
                        this.task_id = response.data.job;

                        Echo.private(`user.task.${this.task_id}`)
                            .listen('TaskCompleted', (e) => {
                                this.processing = false;
                                this.task_id = undefined;
                            });
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>

<style scoped>

</style>