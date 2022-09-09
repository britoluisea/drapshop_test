<template>
	<div class="row">
		<div v-if="status!=null" :class="['alert', (status==1) ? 'alert-success' : 'alert-danger']" role="alert">
			{{message}}
		</div>
		<form @submit.prevent="createSales()">
			<input type="hidden" name="_token" :value="f.csrf">
			<div class="row mb-3">
                <label for="name_user" class="col-md-2 col-form-label text-md-end">Customer:</label>
                <div class="col-md-4">
                    <select class="form-control" v-model="f.customer_id" required>
                    	<option :value="0">Select Customer</option>
                    	<option v-for="(i, index) in listCustomer" :key="index" :value="i.id">{{i.name}} - {{i.email}}</option>                    	
                    </select>
                </div>
                <label for="datenote" class="col-md-2 col-form-label text-md-end">Date:</label>

                <div class="col-md-4">
                	<Datepicker v-model="f.date" :format="'yyyy-MM-dd'" required placeholder="Select date"></Datepicker>
                </div>
            </div>
            <itemsProd :edit="edit"></itemsProd>
            <div class="row mb-0 justify-content-end">
            	<hr>
            	<table style="border:0px; width:300px; margin-bottom: 20px;">
            		<tbody>
            			<tr>
            				<td>Total</td>
            				<td class="text-right">${{f.total}}</td>
            			</tr>
            		</tbody>
            	</table>
            </div>
            <div class="row mb-0">
                <div class="col-md-3 offset-md-3">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
                <div class="col-md-3 offset-md-3">
                    <button type="button" class="btn btn-light" @click="$parent.cancel()">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
	</div>
</template>
<script>
import itemsProd from "../components/itemsProd.vue";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
	name: 'salesForm',
	components: {
		itemsProd,
		Datepicker
	},
	props: {
	  formOpen: {
	    type: Object,
	    required: true,
	    default: () => new Object()
	  }
	},
	data () {
		return {
			f: {
				csrf: document.head.querySelector('meta[name="csrf-token"]').content,
				user_id: 0,
				id: 0,
				customer_id: 0,
				date: new Date().toISOString().slice(0, 10),
				total: '',
				customer: '',
				listItems: [],
				total: 0,
			},
			message: '',
			errors: '',
			status: null,
			listprod: [],
			listCustomer: [],
			edit: false
		}
	},
	created(){
    	let t = this;
        t.f.user_id = t.$store.getters.getUserData.id;
        
    },
	methods : {	
    	getCustomer(){
    		let t = this;
        	t.f.user_id = t.$store.getters.getUserData.id;
            window.axios.post('/getCustomer', {user_id: t.f.user_id})
            .then((r) => {
                console.log('getCustomer', r.data.list);
				t.listCustomer = r.data.list;
            })
            .catch((error) => {
                console.log('error');
            });
        },	
    	newAdd(){
    		let t = this;
			t.emptyFields();
    	},
    	editItem(i){
    		let t = this;
			t.newAdd();
			t.f.user_id= i.user_id;
			t.f.id= i.id;
			t.f.customer_id= i.customer_id;
			t.f.date= i.date;
			t.f.total= i.total;
			t.f.customer= i.customer;
			t.f.listCustomer= [];
			window.axios.post('/getSalesById', t.f)
	            .then((r) => {
	                console.log('getSalesById', r);
	                console.log('items', r.data.r.items);
					t.f.listItems= r.data.r.items;
					t.edit = true;
	            })
	            .catch((error) => {
	                console.log('error');

	            });
    	},
    	createSales(){
    		let t = this;
    		if(t.f.customer_id==0){    			
    			t.message="Select Customer";
				t.status=2;
    		}
    		else if(t.f.listItems.length==0){
    			t.message="Empty product list";
				t.status=2;
    		}else{
    			t.message="Empty product list";
				t.status=2;
	            window.axios.post('/createSales', t.f)
	            .then((r) => {
	                console.log('createSales', r);
						if(r.data.status){;
							t.status=1;
	                		t.message='Saved successfully';
	                		t.emptyFields();
	                		t.$parent.cancel();
	                		t.$parent.getListSales();
						}
	            })
	            .catch((error) => {
	                console.log('error');
	                t.message=error.response.data.message;
	                t.errors=error.response.data.errors;
					t.status=2;
	            });
	        }
    	},
    	emptyFields(){
    		let t= this;			
			t.f.id= 0;
			t.f.customer_id= 0;
			t.f.date= '';
			t.f.total= 0;
			t.f.customer= null;
			t.f.listItems=[];
    	},
	},
	watch: {
		"formOpen.open": function(){
    		let t= this;
			if(t.formOpen.open){
				t.getCustomer();
				if(t.formOpen.action=='add'){
		        	t.newAdd();
		        }else{
		        	t.editItem(t.formOpen.data);
		        }
			}
		},
	},
	computed : {

        
	}
}
</script>
<style lang="css" scoped>

.text-right{
	text-align: right;
}
</style>
