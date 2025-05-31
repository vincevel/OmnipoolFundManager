<template>
    <!-- button class="btn btn-danger d-block" @click="deleteTransaction">Delete</button> -->
<a href="#" @click="deleteTransaction" ><i class="fas fa-trash"></i></a>
 <!--  <input type="text" v-model="ltrans_id"> -->
</template>

<script>
    export default {
        name: "deleteComponent",
        props: ['trans_id'],
        methods: {
          
          deleteTransaction(event){
            event.preventDefault()
            this.$swal({
                  title: 'Delete Transaction? #' + this.ltrans_id,
                  text: "Are You Sure?",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) {

                    axios.post('/deletetransactions',{
                
                        trans_id: this.ltrans_id
                      
                      }) 
                     .then(results => {

                         this.$swal(
                          'Done!',
                          'The transaction has been deleted. Please click View Account again',
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
            ltrans_id: this.trans_id
          }

        },
        mounted() {
            
        }
    }
</script>
