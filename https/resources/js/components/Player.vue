<template>
    <div>
    <div :data-vimeo-id="lesson.video_id" v-if="lesson" id="handstick"></div>
    </div>
</template>

<script>
    import Axios from 'axios'
    import Swal from 'sweetalert'
    import Player from '@vimeo/player'
    export default {
        props: ['default_lesson', 'next_lesson_url'],
        data(){
            return {
                lesson: JSON.parse(this.default_lesson)
            }
        },
        methods: {
            displayVideoEndedAlert(){
                if(this.next_lesson_url){
                    Swal('Yaaa! You completed lesson !!!')
                    .then(() => {
                        window.location = this.next_lesson_url
                   })
                }else{
                    Swal('Yaaa! You completed series !!!')
                }
            },
            completeLesson(){
                Axios.post(`/series/complete-lesson/${this.lesson.id}`, {})
                .then(resp => {
                    this.displayVideoEndedAlert()
                })
            }
        },

        mounted(){
            const player = new Player('handstick')

            player.on('play', () => {
                console.log('our video is playing !')
            })

            player.on('ended', () => {
                this.completeLesson()
            })
        }
    }

</script>