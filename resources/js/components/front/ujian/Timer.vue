<template>
    <span class="text-white rounded-lg py-2 px-2" :class="isNearEnd">
        {{ hours }} jam : {{ minutes }} menit : {{ seconds }} detik
    </span>
</template>

<script>
    import { DateTime } from "luxon";
    
    export default {
        name: 'timer',

        props: {
            end: Number
        },

        data: function() {
                return {
                    start: DateTime.utc().valueOf(),
                    seconds: 0,
                    minutes: 0,
                    hours:0,
                    days: 0,
                    interval: 0,
                };
            },
        
        mounted() {
            // Update the count down every 1 second
            this.timerCount(this.start,this.end);
            this.interval = setInterval(() => {
                this.timerCount(this.start,this.end);
            }, 1000);
        },

        methods: {
            timerCount: function(start,end){
                // Get todays date and time
                const now = DateTime.utc();

                // Find the distance between now an the count down date
                let distance = start - now;
                let passTime =  end - now;

                if(distance < 0 && passTime < 0) {
                    clearInterval(this.interval);
                    this.$emit('finished')
                    return;
                } else if (distance < 0 && passTime <= 300000) {
                    this.calcTime(passTime);
                } else if(distance < 0 && passTime > 0){
                    this.calcTime(passTime);

                } else if( distance > 0 && passTime > 0 ){
                    this.calcTime(distance); 
                }
            },
            
            calcTime: function(dist){
            // Time calculations for days, hours, minutes and seconds
                this.days = Math.floor(dist / (1000 * 60 * 60 * 24));
                this.hours = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                this.minutes = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                this.seconds = Math.floor((dist % (1000 * 60)) / 1000);
            }
            
        },

        computed: {
            isNearEnd() {
                return (this.minutes < 5) ? 'bg-danger' : 'bg-primary';
            }
        }
    }
</script>