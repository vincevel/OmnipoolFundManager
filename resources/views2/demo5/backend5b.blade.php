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

</style>

</head>
<body>
  <h2 id="header_184" class="form-header" data-component="header">

              View Transactions - BLADE 5 - VUEJS BLADE VERSION B

  </h2>
   <div id="app3">  
              <!-- <custom-table></custom-table> -->
              <template v-for="(u_data,u_id,item_id) in items" :id="item_id">
                 
                  <h2>${ u_id }</h2>
                 <!--  <h2>${ u_data }</h2> -->
                  <b-table striped hover :items="u_data" :fields="fields" >
                       
                      <!--  <template v-if="u_data.transaction_type_id=='10'"> -->
                         <template #cell(tbtn1)="u_data" >
                            <template v-if="u_data.item.transaction_type_id!=114" >
                              <b-button size="sm" class="mr-2" v-bind:class="{ superRed: (u_data.item.transaction_type_id==10 | u_data.item.transaction_type_id==3)  }">
                                ${ u_data.item.transaction_type_id }
                              </b-button>
                            </template>
                          </template>
                        <!-- <template> -->

                        <template #cell(tbtn2)="u_data">
                          <b-button size="sm" class="mr-2" @click="test1(u_data)">
                            Delete 
                          </b-button>
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
         axios.get("/sri/api/transactions/getAll",{
              //firstName: this.count
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
          
          console.log(v.item.amount)
          
        }
      },
    delimiters: ['${' , '}']
  })
 
</script>
</body>
</html>