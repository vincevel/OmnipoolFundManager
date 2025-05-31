<template>
<div class="form-group">
            <input type="input" class="form-control" id="input_3" name="email" aria-describedby="emailHelp" v-model="lemail" placeholder="Enter email, first name or last name">
          </div>

<div class="text-center">
    <button @click="loaddata2" id="input_2" type="submit" class="btn btn-primary my-2" data-component="button" data-content="">Search</button>
</div>
  <br>




  <div class="d-flex flex-row" >

    <div class="justify-content-center" style="border: 0px solid red">
        <table id="searchtable2" style="border: 1px solid black; " class="table table-striped table-bordered  table-hover table-responsive"  >
          <thead style=" ">
            <tr >
              <td>First Name</td>
              <td>Last Name</td>
              <td>Id</td>
              <td>Email</td>
              <td>Bitcoin_Address</td>
              <td>ThisMonth</td>
              <td>NextMonth</td>
              <td>View Account</td>
              <td>View Details</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items">


              <td class="px-3">{{ item.first_name }}</td>
              <td class="px-3">{{ item.last_name }}</td>
              <td class="px-3">{{ item.id-2 }}</td>
              <td class="px-3">{{ item.email }}</td>
              <td class="px-3">{{ item.bitcoin_address }}</td>
              <td class="px-3"> <span v-if="item.isDeferred1 == 0">Payout</span>
              <span v-else >Deferred</span></td>
              <td class="px-3"> <span v-if="item.isDeferred2 == 0">Payout</span>
              <span v-else >Deferred</span></td>
              <td class="px-3"><input @click="showTransaction(item.id,$event)" type="submit" value="View" class="btn btn-primary"></td>
              <td class="px-3"><a :href="/getusertransactions/+item.id" target="_blank" class="btn btn-primary">View Details</a></td>
            </tr>
          </tbody>
        </table> 
    </div>
  </div>
  
  
        <br>
        <br>

  <div v-if="firstTimeTransactions == true">
     

  </div>
  <div v-else class="container" style="background-color: white; border:1px solid black"> 
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
        <br>
        <h2>View Transactions</h2>
        <br>
        <table id="transactiontable" style="" class="table table-striped" >
          <thead>
          <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Transaction Type</th>
            <th>Delete</th>
            
          </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in transactions" v-bind:key="transaction.id">
              <td class="px-3">{{ transaction.date_transaction }}</td>
              <td class="px-3">{{ transaction.amount }} </td>
              <td class="px-3">{{ transaction.transaction_type_id }} </td>
              <td class="px-3"><delete-component :trans_id="transaction.id"></delete-component></td>
            </tr>
          </tbody>
        </table> 
        </div>

        <div class="col-md-3">
        </div>

      </div>
    </div>
 


</template>

<script>

    import DeleteComponent from './DeleteComponent.vue';

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components: {
          'delete-component' : DeleteComponent
        },
         props: ['email'],
      methods: {
        loaddata2(event) {
        

          event.preventDefault();
            axios.post('/dividenduser',{
                email: this.lemail,
            }) 
           .then(results => {
             //console.log(results.data)
             if (results.data == 0){
               //this.items[0] = "No Results Found";
               this.items = []
             } else {

               // $('#searchtable2').DataTable();
               // initDataTables();
               this.items = results.data

              //if (this.firstTime == true){ 
                //initDataTables();  
              //}


               this.firstTime = false 
               console.log(this.items)
             }
           })
          
        },
        showTransaction(a,event) {
            //$('#transactiontable').DataTable();
            //alert(a);
            event.preventDefault();

              axios.post('/gettransactions',{
                email: a,
              }) 
             .then(results => {
               //console.log(results.data)
               if (results.data == 0){
                 //this.items[0] = "No Results Found";
                 this.items = []
               } else {

                 // $('#searchtable2').DataTable();
                 // initDataTables();
                 this.transactions = []
                 this.transactions = results.data
                 
                 console.log(this.items)
               }
             })
            
            //pull data from here. pull what data? based on button pressed?

            if (this.firstTimeTransactions == true){
              initDataTables(); 
              this.firstTimeTransactions = false;
            }
            
            //initDataTables();
             
        }
      },
      computed: {
      },
      data() {
        return {
          count: 0,
          leligible: this.eligible,
          lemail: this.email,
          btnText: "Update",
          firstTime: true,
          secondTime: true,
          firstTimeTransactions: true,
          items: [],
          transactions: []
        }
      }
    }
</script>
