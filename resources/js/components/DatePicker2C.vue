    
<template>
     <div>
    <!-- <h3>Upload Transactions Active Form</h3> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h3>Enter Transaction Data</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="transaction_input">Enter Id Of User:</label>
                                <input type="input" v-model="ld_id" id="id_input" name="id_input" class="form-control" readonly> 
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
	name: 'customform',
        props: ['u_id','d_id'],
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
            onImageChange(e){
                this.image=e.target.files[0];
            },
            submit_transactions(event) {
                axios.get('/get_user_former_txs',{
                    params:{
                        user_id:this.ld_id,
                        date_transaction:moment(this.ldate2).format('YYYY-MM-DD'),
                        amount:this.lamount,
                        transaction_type_id:this.ltype
                    }
                }) 
                     .then((res) => {
                        let title="Upload Transaction?"
                        let msg="Are You Sure?";
                        if(parseInt(res.data)!=0){
                            title="Duplicate Transaction Exists"
                            msg="A duplicate transaction exists, Do you want to continue?"
                        }
                        this.$swal({
                            title: title,
                            text: msg,
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
                    
                    formData.append('id',this.ld_id);
                    formData.append('date',moment(this.ldate2).format('YYYY-MM-DD'));
                    formData.append('amount',this.lamount);
                    formData.append('type',this.ltype);
                    formData.append('transactions',1);
                    axios.post('/submittransactions',formData,config) 
                     .then(results => {

                         this.$swal(
                          'Done!',
                          'Your data has been saved. Please click View Account Again ',
                          'success'
                        ).then( results2 => { 
                         location.reload();
                        })
                        
                         console.log(results)
          
                     })


                   
                  }
                })
                
          
                     })
                

                
            }
          },
        data() {
            return {
                  count: 0,
                  ldate2: "",
                  lid: "",
                  image:"",
                  lu_id: this.u_id,
                  ld_id: this.d_id,
                  lamount: "",
                  ltype: "1",
            };
        }
    }
</script>
