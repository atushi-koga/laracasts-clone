<template>
    <div class="container" style="color: black; font-weight: bold;">
        <h1 class="text-center">
            <button class="btn btn-primary" @click="createNewLesson()">
                Create New Lesson
            </button>
        </h1>
		<div class="">
            <ul class="list-group d-flex">
                <li class="list-group-item d-flex justify-content-between" v-for="lesson, key in lessons">
                    <p>{{ lesson.title }}</p>
                    <p>
                        <button class="btn btn-primary btn-xs" @click="editLesson(lesson)">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-xs" @click="deleteLesson(lesson.id, key)">
                            Delete
                        </button>
                    </p>
                </li>
            </ul>
        </div>
        <create-lesson></create-lesson>
    </div>
</template>

<script>
    import Axios from 'axios'
    export default {
        props: ['default_lessons', 'series_id'],
        mounted() {
            this.$on('lesson_created', (lesson) => {
                window.noty({
                    message: 'lesson created successfully!',
                    type: 'success'
                })
                this.lessons.push(lesson)
            })

            this.$on('lesson_updated', (lesson) => {
                let lessonIndex = this.lessons.findIndex(l => {
                    return lesson.id == l.id
                })

                window.noty({
                    message: 'lesson edited successfully!',
                    type: 'success'
                })
                this.lessons.splice(lessonIndex, 1, lesson)
            })
        },
        components: {
            "create-lesson": require('./children/CreateLesson.vue')
        },
        data(){
            return {
                lessons: JSON.parse(this.default_lessons)
            }
        },
        methods: {
            createNewLesson(){
                this.$emit('create-new-lesson', this.series_id)
            },
            deleteLesson(id, key){
                if(confirm('Are you sure you wanna delete ?')){
                    axios.delete(`/admin/${this.series_id}/lessons/${id}`)
                    .then(resp => {
                        this.lessons.splice(key, 1)
                        window.noty({
                            message: 'lesson deleted successfully!',
                            type: 'success'
                        })
                    }).catch(error => {
                        window.handleError(error)
                    })
                }
            },
            editLesson(lesson){
                let seriesId = this.series_id
                this.$emit('edit-lesson', { lesson, seriesId })
            }
        }
    }
</script>

