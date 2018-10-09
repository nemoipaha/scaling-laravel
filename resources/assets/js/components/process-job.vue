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
                processing: false
            };
        },

        methods: {
            createJob() {
                axios.post('/job')
                    .then(() => {
                        this.processing = true;
                    })
                    .catch(error => {

                    })
            }
        }
    }
</script>

<style scoped>

</style>