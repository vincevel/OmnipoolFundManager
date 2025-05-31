<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

<!-- Load required Bootstrap and BootstrapVue CSS -->
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />

<style type="text/css">
  
    #app3{

        margin:30px;

    }
    #header_184{

        margin:30px;

    }

    .superRed {
      background-color: red !important;
    }

    .topBtn {
      margin:40px;
    }

    .superRedColor {
      color: red !important;
    }

    .superGreenColor {
      color: green !important;
    }

    .superBackroundGreenColor {
      background-color: green !important;
    }

</style>

</head>
<body>
  <div id="app5" class="">

     <b-button size="sm" class="mr-2 topBtn" @click="updaterbalance">
       Update Running balance 
     </b-button>
  </div>

  <h2 id="header_184" class="form-header" data-component="header">

              View Transactions - BLADE 5 - VUEJS BLADE VERSION C

  </h2>
   <div id="app3">  
              <!-- <custom-table></custom-table> -->
              <template v-for="(u_data,u_id,item_id) in items" :id="item_id">
                 
                  <h2>${ u_id }</h2>
                 <!--  <h2>${ u_data }</h2> -->
                  <b-table striped hover :items="u_data"  >
                       
                      <!--  <template v-if="u_data.transaction_type_id=='10'"> -->
                        <template #cell(e_amount)="u_data">
                          <input v-model="u_data.item.e_amount">

                          <b-button size="sm" class="mr-2" @click="updateEligibleAmount(u_data.item)">
                            Update 
                          </b-button>
                        </template>


                          <template #cell(eligible)="u_data">
                          <input v-model="u_data.item.eligible">

                          <b-button size="sm" class="mr-2" v-bind:class="{ superBackroundGreenColor: u_data.item.eligible == 1 }" @click="updateEligible(u_data.item)">
                            Update 
                          </b-button>
                        </template>

                        <template #cell(transaction_type_id)="u_data">
                            <template v-if="u_data.item.transaction_type_id==3">
                              WITHDRAW
                            </template>
                            <template v-else>
                              ${ u_data.item.transaction_type_id }
                            </template>
                        </template>

                        <template #cell(r_balance)="u_data">
                     
                            <span v-bind:class="{ superRedColor: u_data.item.r_balance <= 0 }">  ${ u_data.item.r_balance } <span>
                            <template v-if="u_data.item.r_balance <= 0"> 
                                  <b-button size="sm" class="mr-2">
                                 INVALID
                                </b-button>
                            </template>

                        </template>

                        <template #cell(to_process)="u_data">
                     
                            <span v-bind:class="{ superRedColor: u_data.item.to_process == 1 }">  ${ u_data.item.to_process } <span>
                         
                        </template>

                         <!-- Optional default data cell scoped slot -->
                        

                  </b-table>
                  <br/>
                  <br/>
                 
              </template>
           </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js" integrity="sha512-lTLt+W7MrmDfKam+r3D2LURu0F47a3QaW5nF0c6Hl0JDZ57ruei+ovbg7BrZ+0bjVJ5YgzsAWE+RreERbpPE1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <!--  <script src="https://unpkg.com/vue@3.0.5/dist/vue.global.prod.js"></script> -->



<!-- Load polyfills to support older browsers -->
<!-- <script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script> -->

<!-- Load Vue followed by BootstrapVue -->

<script src="//unpkg.com/vue@latest/dist/vue.min.js"></script> 
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>

<!-- Load the following for BootstrapVueIcons support -->
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.js"></script>
<!-- 
<template>
  <div>
    <b-table striped hover :items="items"></b-table>
  </div>
</template> -->

<script>
  
</script> 

<script>

   var app2 = new Vue({
    el: '#app3',
    data: {
      state: [],
      lorg: "United Sugar Planters of Digos",
      message: '',
      items: [
          // { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
          // { age: 21, first_name: 'Larsen', last_name: 'Shaw' }, 
          // { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
          // { age: 38, first_name: 'Jami', last_name: 'Carney' }
        ],
        fields: [
          {key: 'user_id',label: 'Uid',sortable: true},
          {key: 'date_transaction',label: 'Date',sortable: true},
          // {key: 'dividend_payout',label: 'Dividend Payout',sortable: true},
          // {key: 'contribution_payout',label: 'Contribution Payout',sortable: true},
          {key: 'amount',label: 'Amount',sortable: true},
          // {key: 'running_balance',label: 'Running Balance',sortable: true},
          {key: 'transaction_type_id',label: 'Code',sortable: true},
          {key: 'status',label: 'Status',sortable: true},
          {key: 'remarks',label: 'Remarks from SEDPI',sortable: true},
          {key: 'tbtn1',label: 'View',sortable: true},
          {key: 'tbtn2',label: 'Delete',sortable: true}
       
        ],
          
    },
    created() {

        
         /*
         axios.post("/sri/api/dividendupdate/updaterbalance",{
              //firstName: this.count
              org: this.lorg
          }) 
          .then(results => {
            //this.items = results.data
            console.log(results.data)
            //const map1 = results.data.map(x=> ({ 
            //      ...x, newval : '<b-button href="#">I am a Link</b-button>' 
            //    })
            //  );
            //console.log(map1)
            //this.items = map1
          })
        */
      
        axios.get("/sri/api/transactions/getAllDividends",{
              //firstName: this.count
              org: this.lorg
          }) 
          .then(results => {
            this.items = results.data
            console.log(results.data)
            //const map1 = results.data.map(x=> ({ 
            //      ...x, newval : '<b-button href="#">I am a Link</b-button>' 
            //    })
            //  );
            //console.log(map1)
            //this.items = map1
          })
      

    },
    methods: {
        test1(v) {
            event.preventDefault();
          //console.log(v.item.amount)
          console.log(v)
         
           axios.post("/sri/api/dividendupdate/updateeligible",{
              firstName: this.first_name,
              lastName: this.last_name,
              userId: this.user_id
          }).then(results => {
            // this.variants = results.data.variants
            // this.option = 1;
            // this.variant = this.variants[this.option-1].id
            // this.hasBeenAdded = false
            //this.variant = results.data.variants[0].id
            console.log(results)
          })
          
        },
        updateEligible(v) {
            event.preventDefault();
          //console.log(v.item.amount)
          console.log(v)
          //u_data.item

           axios.post("/sri/api/dividendupdate/updateeligible",{
              t_id: v.transaction_id,
              eligible: v.eligible
          }).then(results => {
            console.log(results)
          })
          
        },
        updateEligibleAmount(v) {
          event.preventDefault();
          //console.log(v.item.amount)
          console.log(v)
          //u_data.item

           axios.post("/sri/api/dividendupdate/updateeligibleamount",{
              t_id: v.transaction_id,
              e_amount: v.e_amount
          }).then(results => {
            console.log(results)
          })
          
        }  
      },
    delimiters: ['${' , '}']
  })
 
</script>


<script>

   var app5 = new Vue({
    el: '#app5',
    data: {
      lorg: "MII1",
    },
    created() {
      
    },
    methods: {
       updaterbalance(v) {
          //console.log(v.item.amount)
          //console.log(v)
            axios.post("/sri/api/dividendupdate/updaterbalance",{
              //firstName: this.count
              org: this.lorg
            }) 
            .then(results => {
              //this.items = results.data
              console.log(results.data)
              //const map1 = results.data.map(x=> ({ 
              //      ...x, newval : '<b-button href="#">I am a Link</b-button>' 
              //    })
              //  );
              //console.log(map1)
              //this.items = map1
            })
         
          
        }
      
    },
    delimiters: ['${' , '}']
  })
 
</script>

</body>
</html>