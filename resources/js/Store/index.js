import Vue from 'vue'
import Vuex from 'vuex'

const store = new Vuex.Store({


	state: {

		count: 19,
	},
	mutations: {

		INCREMENT(state,number) {
			state.count += number
		},

	},
	actions: {}

})


export default store;
