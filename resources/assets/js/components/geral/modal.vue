<template>
    <div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button @click="initAddPost()" class="btn btn-primary btn-xs pull-right">
                        + Add New Post
                    </button>
                    My Post
                </div>

                <div class="panel-body">

                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="add_post_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Add New Post</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" placeholder="Title Name" class="form-control"
                                   v-model="posts.title">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                      placeholder="Post Description" v-model="posts.description"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createPost" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </div>
</template>

<script>

    export default {
        data() {
            return {
                posts: {
                    title: '',
                    description: ''
                },
                errors: [],
                posts: [],
                update_post: {}
            }
        },
        mounted() {
            this.readPosts();
        },
        methods: {
            initAddPost() {
                this.errors = [];
                $("#add_post_model").modal("show");
            },
            createPost() {
                axios.post('/posts',
                    {
                    title: this.posts.title,
                    description: this.posts.description,
                })
                    .then(response => {

                        this.reset();

                        $("#add_post_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.title) {
                            this.errors.push(error.response.data.errors.title[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            reset() {
                this.posts.title = '';
                this.posts.description = '';
            },
            readPosts() {
                axios.get('/previsao-entrega/teste').then(results => console.log(results))
            },
            initUpdate(index) {
                this.errors = [];
                $("#update_post_model").modal("show");
                this.update_post = this.posts[index];
            }
        }
    }
</script>