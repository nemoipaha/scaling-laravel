<template>
    <div class="panel-body">
        <div class="form-group" v-if="imageId">
            <img v-bind:src="imageUri" class="img-circle" style="max-width: 200px;" />
        </div>
        <div class="form-group">
            <label for="profile">Upload Profile Photo</label>
            <input type="file" name="profile" id="profile">
        </div>
        <button type="submit" class="btn btn-default" @click.prevent="upload">Upload</button>
    </div>
</template>

<script>
    export default {
        props: ['profile_image'],

        data() {
            return {
                imageId: null,
            }
        },

        computed: {
            imageUri() {
                return 'profile/image/' + this.imageId;
            }
        },

        mounted() {
            if (this.profile_image) {
                this.imageId = this.profile_image
            }
        },

        methods: {
            upload() {
                const vm = this;
                const data = new FormData();
                data.append('profile', document.getElementById('profile').files[0]);

//                ## I didn't implement this, but it's a fun thing you can do!
//                var config = {
//                    onUploadProgress: function (progressEvent) {
//                        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
//                        console.log(percentCompleted);
//                    }
//                };

                axios.post('/profile/image', data, {})
                    .then(function (res) {
                        vm.imageId = res.data.id;
                    })
                    .catch(function (err) {
                        console.log('UPLOAD ERROR:', err.message);
                    });
            }
        }
    }
</script>