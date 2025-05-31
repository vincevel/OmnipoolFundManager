    
<template>
     <div>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <form>
                    <div class="card">
                        <div class="card-header">
                            <h3>Change User Settings</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="dis_id">User Id:</label>
                                <input type="input" v-model="dis_id" id="dis_id" name="dis_id" class="form-control" readonly> 
                            </div>


                            <div class="form-group">
                                <label for="interest">Interest Rate:</label>
                                <input id="interest" type="input" name="interest" class="form-control" v-model="int"  > 
                            </div>
                            <div class="form-check">
                                
                                <input id="verified" type="checkbox" name="verified" class="form-check-input" v-model="verify" 
                                
                                 > 
                                <label for="verified" class="form-check-label">Verified</label>
                            </div>
                    

                            <div class="form-group">
                                    <a @click="change_percentage" href="#" class="d-block btn btn-primary">Change</a> 
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
	      name: 'changeinterestrate',
        props: ['user_id','interest','verified'],
        components: { Datepicker },
        
	mounted: function () {
   	 
  	},
        methods: {
        
            change_percentage(event) {

                this.$swal({
                  title: 'Change User Settings?',
                  text: "Are You Sure?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                  if (result.isConfirmed) {

                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    let formData=new FormData();
                    
                    formData.append('user_id',this.user_id);
                    formData.append('interest',this.int);
                    formData.append('verified',(this.verify?1:0));
                    console.log(this.verify);
                    axios.post('/changeinterestrate',formData,config) 
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
                  dis_id: this.user_id-2,
                  user_id: this.user_id,
                  int: this.interest,
                  verify: this.verified==1?true:false,
            };
        }
    }
</script>
