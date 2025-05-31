    
<template>
     <div>
    <!-- <h3>Upload Transactions</h3> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form>
                    <div class="card">
                        <div class="card-header">
                            <h3>Enter Transaction Data</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="transaction_input">Transaction Id:</label>
                                <input type="input" v-model="ltransaction_id" id="transaction_input" name="transaction_input" class="form-control" readonly> 
                            </div>

                            <div class="form-group">
                                <label for="transaction_input">Enter Date: <!--  <span class="text-muted">(format:year-month-day / 2022-03-10 ) </span> --> </label>

                                <!-- <input  type="input"   name="transaction_input" class="form-control" v-model="ldate2"  >--> 
                                <Datepicker v-model="linput_date" :format="format"></Datepicker>
                            </div>

                            <div class="form-group">
                                <label for="amount_input">Enter Amount:</label>
                                
                                <input type="input" name="amount_input" class="form-control" v-model="lamount"  > 

                            </div>
                    
                         
                            <div class="form-group">
                                  <label for="type_select">Select Type</label>
                            <select class="form-control" id="type_select" v-model="ltransaction_type">
                              <option value="1">Deposit</option>
                              <option value="4">Withdraw</option>
                              <option value="3">Deferred Payout</option>
                              <option value="7">Dispersed Payout</option>
                              <option value="5">Bonus</option>
                              <option value="6">Omniventures Payment</option>
 
                            </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Receipt</label>
                                <input type="file" name="image" class="form-control" v-on:change="onImageChange">
                            </div>
                            <img :src="getImage()" width="200" height="200">

                            <div class="form-group">
                                    <a @click="submit_transactions" href="#" class="d-block btn btn-primary">Upload</a> 
                            </div>
                            <div class="form-group">
                            	<a class="d-block btn btn-secondary" data-dismiss="modal">Cancel</a>
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
    //import VModal from 'vue-js-modal'

    export default {
	name: 'customeditform',
        props: ['transaction_id','input_date','amount','transaction_type','image'],
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
	mounted: function () {
   	 // `this` points to the vm instance
    	//console.log('at mounted')
  	},
        methods: {
            getImage(){
                          return  '../images/'+this.url;
            },
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

                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    let formData=new FormData();
                    formData.append('image',this.image);
                    
                    formData.append('transaction_id',this.transaction_id);
                    formData.append('input_date',moment(this.linput_date).format('YYYY-MM-DD'));
                    formData.append('amount',this.lamount);
                    formData.append('transaction_type',this.ltransaction_type);
                    
                    axios.post('/submitedittransactions',formData,config) 
                     .then(results => {

                         this.$swal(
                          'Done!',
                          'Your data has been saved.',
                          'success'
                        ).then( results2 => { 
                         location.reload();
                        })
                        
                         console.log(results)
          
                     })


                   
                  }
                })

                
            }
          },
        data() {
            return {
                  count: 0,
                  linput_date: this.input_date,
                  lid: "",
                  image:"",
                  url:this.image,
                  lamount: this.amount,
                  ltransaction_id: this.transaction_id,
                  ltransaction_type: this.transaction_type,
            };
        }
    }
</script>
