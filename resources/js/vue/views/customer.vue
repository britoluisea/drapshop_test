<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						Customer 
						<button type="button" class="btn btn-light btn-light2" @click="newAddCustomer()">Add+</button>
					</div>
					<div class="card-body">
						<div v-if="status!=null" :class="['alert', (status==1) ? 'alert-success' : 'alert-danger']" role="alert">
							{{message}}
						</div>
						<form @submit.prevent="setCustomer()" v-if="showForm">
							<input type="hidden" name="_token" :value="f.csrf">
							<div class="row mb-3">
	                            <label for="name_user" class="col-md-4 col-form-label text-md-end">Name</label>

	                            <div class="col-md-6">
	                                <input id="name_user" type="text" class="form-control" v-model="f.name" required autocomplete="name_user">
	                            </div>
	                        </div>
							<div class="row mb-3">
	                            <label for="name_email" class="col-md-4 col-form-label text-md-end">Email</label>

	                            <div class="col-md-6">
	                                <input id="name_email" type="text" class="form-control" v-model="f.email" autocomplete="name_email">
	                            </div>
	                        </div>
							<div class="row mb-3">
	                            <label for="name_address" class="col-md-4 col-form-label text-md-end">Address</label>

	                            <div class="col-md-6">
	                                <input id="name_address" type="text" class="form-control" v-model="f.address" autocomplete="name_address">
	                            </div>
	                        </div>

	                        <div class="row mb-0">
	                            <div class="col-md-3 offset-md-3">
	                                <button type="submit" class="btn btn-primary">
	                                    Save
	                                </button>
	                            </div>
	                            <div class="col-md-3 offset-md-3">
	                                <button type="button" class="btn btn-light" @click="cancel()">
	                                    Cancel
	                                </button>
	                            </div>
	                        </div>
	                    </form>
	                    <div class="row" v-else>
	                    	<table class="table table-bordered table-inverse table-hover">
	                    		<thead>
	                    			<tr>
	                    				<th width="50px" class="text-center">Id</th>
	                    				<th>Name</th>
	                    				<th>Email</th>
	                    				<th>Address</th>
	                    				<th width="50px"></th>
	                    			</tr>
	                    		</thead>
	                    		<tbody v-if="list.length==0">
	                    			<tr>
	                    				<td colspan="5" class="text-center">No record</td>
	                    			</tr>
	                    		</tbody>
	                    		<tbody v-else>
	                    			<tr v-for="(i, index) in list" :key="index">
	                    				<td width="50px" class="text-center">{{i.id}}</td>
	                    				<td>{{i.name}}</td>
	                    				<td>{{i.email}}</td>
	                    				<td>{{i.address}}</td>
	                    				<td width="50px" class="text-center">
	                    					<button type="button" class="btn btn-primary btn-sm" @click="editCustomer(i)"><i class="fa fa-edit"></i></button>
	                    				</td>
	                    			</tr>
	                    		</tbody>
	                    	</table>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
	name: 'customer',
	data () {
		return {
			f: {
				csrf: document.head.querySelector('meta[name="csrf-token"]').content,
				user_id: 0,
				id: 0,
				name: '',
				email: '',
				address: '',
			},
			message: '',
			errors: '',
			status: null,
			showForm: false,
			list: [],
		}
	},
	created(){
        this.f.user_id = this.$store.getters.getUserData.id;
        if(this.f.user_id != undefined){
        	this.getCustomer();
        }
    },
    methods : {
    	newAddCustomer(){
    		let t = this;
			t.emptyFields();
			t.showForm = true;;
    	},
    	editCustomer(i){
    		let t = this;
			t.newAddCustomer();
			t.f.user_id= i.user_id;
			t.f.id= i.id;
			t.f.name= i.name;
			t.f.email= i.email;
			t.f.address= i.address;
    	},
    	cancel(){
    		let t = this;
			t.showForm = false;
    	},
    	getCustomer(){
    		let t = this;
            window.axios.post('/getCustomer', t.f)
            .then((r) => {
                console.log('getCustomer', r);
				t.list = r.data.list;
            })
            .catch((error) => {
                console.log('error');
            });},
    	setCustomer(){
    		let t = this;
            window.axios.post('/setCustomer', t.f)
            .then((r) => {
                console.log('setCustomer', r);
					if(r.data.status){;
						t.status=1;
                		t.message='Saved successfully';
                		t.emptyFields();
                		t.cancel();
                		t.getCustomer();
					}
            })
            .catch((error) => {
                console.log('error');
                t.message=error.response.data.message;
                t.errors=error.response.data.errors;
				t.status=2;
            });
    	},
    	emptyFields(){
    		this.f = {
				csrf: document.head.querySelector('meta[name="csrf-token"]').content,
				user_id: this.$store.getters.getUserData.id,
				id: 0,
				name: '',
				email: '',
				address: '',
			};
    	}
	},
    watch:{
        "getUserData": function(){
        	this.f.user_id = this.$store.getters.getUserData.id;
	        if(this.f.user_id != undefined){
	        	this.getCustomer();
	        }
        }
    },
    computed: {
        ...mapGetters({ getUserData: 'getUserData' })
    }
}
</script>
<style lang="css" scoped>
</style>
