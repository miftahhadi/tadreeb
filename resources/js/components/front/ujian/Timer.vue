<template>
    <div>
        {{ hours }} jam : {{ minutes }} menit : {{ seconds }} detik
    </div>
</template>

<script>
    import { DateTime } from "luxon";
    
    export default {
        name: 'timer',

        props: {
            timeExpires: Number
        },

        data: function() {
                return {
                    start: DateTime.utc(),
                    end: null,
                    seconds: 0,
                    minutes: 0,
                    hours:0,
                    days: 0,
                    interval: 0,
                };
            },
        
        mounted() {
            this.setEnd();

            // Update the count down every 1 second
            this.timerCount(this.start,this.end);
            this.interval = setInterval(() => {
                this.timerCount(this.starttime,this.endtime);
            }, 1000);
        },

        methods: {
            setEnd() {
                this.end = DateTime.fromMillis(this.timeExpires);
            },

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
                    this.$emit('near:end')
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
            
        }
    }
</script>