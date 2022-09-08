<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Change password</div>
					<div class="card-body">
						<div v-if="status!=null" :class="['alert', (status==1) ? 'alert-success' : 'alert-danger']" role="alert">
							{{message}}
						</div>
						<form @submit.prevent="changePass()">
							<input type="hidden" name="_token" :value="f.csrf">
							<div class="row mb-3">
	                            <label for="new_password" class="col-md-4 col-form-label text-md-end">New password</label>

	                            <div class="col-md-6">
	                                <input id="new_password" type="password" class="form-control" v-model="f.new_password" required autocomplete="new_password">
	                            </div>
	                        </div>
							<div class="row mb-3">
	                            <label for="confirm_password" class="col-md-4 col-form-label text-md-end">Confirm password</label>

	                            <div class="col-md-6">
	                                <input id="confirm_password" type="password" class="form-control" v-model="f.confirm_password" required autocomplete="confirm_password">
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
	name: 'security',
	data () {
		return {
			f: {
				csrf: document.head.querySelector('meta[name="csrf-token"]').content,
				id: 0,
				new_password: '',
				confirm_password: '',
			},
			message: '',
			errors: '',
			status: null,
		}
	},
    created(){
        this.f.id = this.$store.getters.getUserData.id;
        console.log('user_id', this.f.id)
    },
    methods : {
    	changePass(){
    		let t = this;
            window.axios.post('/changePass', t.f)
            .then((r) => {
                console.log('getUser', r);
                	t.message='Saved successfully';
					t.status=1;
                	t.emptyFields();
            })
            .catch((error) => {
                console.log('error al obtener data de user');
                t.message=error.response.data.message;
                t.errors=error.response.data.errors;
				t.status=2;
            })
    	},
    	emptyFields(){
    		this.f = {
				csrf: document.head.querySelector('meta[name="csrf-token"]').content,
				id: 0,
				new_password: '',
				confirm_password: '',
			};
    	}
    },
    watch:{
        "getUserData": function(){
        	this.f.id = this.$store.getters.getUserData.id;
        	console.log('user_id', this.f.id)
        }
    },
    computed: {
        ...mapGetters({ getUserData: 'getUserData' })
    }
}
</script>
<style lang="css" scoped>
</style>
