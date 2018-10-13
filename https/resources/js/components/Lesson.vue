<template>
    <div class="container text-center" style="color: black; font-weight: bold;">
        <h1 class="text-center">
            <button class="btn btn-primary" @click="createNewLesson()">
                Create New Lesson
            </button>
        </h1>

        <ul class="list-group">
            <li class="list-group-item" v-for="lesson in lessons">
                {{ lesson.title }}
            </li>
        </ul>
        <create-lesson></create-lesson>
    </div>
</template>

<script>
    export default {
        props: ['default_lessons', 'series_id'],
        mounted() {
            this.$on('lesson_created', (lesson) => {
                this.lessons.push(lesson)
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
            }
        }
    }
</script>

