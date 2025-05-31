    
<template>
     <div>
    <!-- <h3>Upload Transactions</h3> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="card">
                        <div class="card-header">
                            <h3>Enter Transaction Data</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="transaction_input">Enter Id Of User:</label>
                                <input type="input" name="id_input" class="form-control" v-model="lid"  > 
                            </div>

                            <div class="form-group">
                                <label for="transaction_input">Enter Date: <!--  <span class="text-muted">(format:year-month-day / 2022-03-10 ) </span> --> </label>

                                <!-- <input  type="input"   name="transaction_input" class="form-control" v-model="ldate2"  >--> 
                                <Datepicker v-model="ldate2" :format="format"></Datepicker>
                            </div>

                            <div class="form-group">
                                <label for="amount_input">Enter Amount:</label>
                                
                                <input type="input" name="amount_input" class="form-control" v-model="lamount"  > 

                            </div>
                    
                         
                            <div class="form-group">
                                  <label for="type_select">Select Type</label>
                            <select class="form-control" id="type_select" v-model="ltype">
                              <option value="1">Deposit</option>
                              <option value="3">Deferred</option>
                              <option value="4">Withdraw</option>
                              <option value="5">Bonus</option>
 
                            </select>
                            </div>

                            <div class="form-group">
                                    <a @click="submit_transactions" href="#" class="d-block btn btn-primary">Upload</a> 
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

  </div>
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

                this.$swal({
                  title: 'Upload Transaction?',
                  text: "Are You Sure?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, upload it!'
                }).then((result) => {
                  if (result.isConfirmed) {

                    axios.post('/submittransactions',{
                
                        id: this.lid,
                        date: this.ldate2,
                        amount: this.lamount,
                        type: this.ltype,
                        transactions : 1
                      }) 
                     .then(results => {

                         this.$swal(
                          'Done!',
                          'Your data has been saved. Please click View Account Again ',
                          'success'
                        )
                        
                         console.log(results)
          
                     })


                   
                  }
                })

                
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
