    
<template>
        <Datepicker v-model="ldate2" :format="format"></Datepicker>
</template>

<script>
    import Datepicker from '@vuepic/vue-datepicker';
    import '@vuepic/vue-datepicker/dist/main.css';
    import { ref } from 'vue';

    export default {
        components: { Datepicker },
        setup() {
            const date = ref(new Date());
            // In case of a range picker, you'll receive [Date, Date]
            const format = (date) => {
                const day = date.getDate();
                const month = date.getMonth() + 1;
                const year = date.getFullYear();

                return `Date: ${day}/${month}/${year}`;
            }
            
            return {
                date,
                format,
            }
        },
        methods: {
            submit_transactions(event) {
            }
          },
        data() {
            return {
                  count: 0,
                  ldate2: "",
                  lid: "",
                  lamount: "",
                  ltype: "1",
            };
        }
    }
</script>
