<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Account</div>
					<div class="card-body">
						<div v-if="status!=null" :class="['alert', (status==1) ? 'alert-success' : 'alert-danger']" role="alert">
							{{message}}
						</div>
						<form @submit.prevent="editUser()">
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
	                                <input id="name_email" type="text" class="form-control" v-model="f.email" required autocomplete="name_email">
	                            </div>
	                        </div>

	                        <div class="row mb-0">
	                            <div class="col-md-6 offset-md-4">
	                                <button type="submit" class="btn btn-primary">
	                                    Save
	                                </button>
	                            </div>
	                        </div>
	                    </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
	name: 'account',
	data () {
		return {
			f: {
				csrf: document.head.querySelector('meta[name="csrf-token"]').content,
				id: 0,
				name: '',
				email: '',
			},
			message: '',
			errors: '',
			status: null,
		}
	},
	created(){
        this.f.id = this.$store.getters.getUserData.id;
        this.f.name = this.$store.getters.getUserData.name;
        this.f.email = this.$store.getters.getUserData.email;
    },
    methods : {
    	editUser(){
    		let t = this;
            window.axios.post('/editAccount', t.f)
            .then((r) => {
                console.log('getUser', r);
                	t.message='Saved successfully';
					t.status=1;
					if(r.data.status){;
                		t.$store.commit('setUserData', r.data.user);
					}
            })
            .catch((error) => {
                console.log('error al obtener data de user');
                t.message=error.response.data.message;
                t.errors=error.response.data.errors;
				t.status=2;
            })
    	}
	},
    watch:{
        "getUserData": function(){
        	this.f.id = this.$store.getters.getUserData.id;
        	this.f.name = this.$store.getters.getUserData.name;
        	this.f.email = this.$store.getters.getUserData.email;
        }
    },
    computed: {
        ...mapGetters({ getUserData: 'getUserData' })
    }
}
</script>
<style lang="css" scoped>
</style>
