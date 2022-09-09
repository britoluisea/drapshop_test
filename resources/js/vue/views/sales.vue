<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						Notes Sales 
						<button type="button" class="btn btn-light btn-light2" @click="newAdd()" v-show="!showForm">Add+</button>
					</div>
					<div class="card-body">
						<salesForm v-show="showForm" :formOpen="formOpen"></salesForm>
	                    <salesTable :list="list" v-show="!showForm"></salesTable>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { mapGetters } from "vuex";
import salesTable from "../components/salesTable.vue";
import salesForm from "../components/salesForm.vue";
export default {
	name: 'sales',
	components: {
		salesTable,
		salesForm,
	},
	data () {
		return {
			showForm: false,
			formOpen: {
				open: false,
				action: 'add',
				data: {},
			},
			user_id: 0,
			list: [],
		}
	},
	created(){
        this.user_id = this.$store.getters.getUserData.id;
        if(this.user_id != undefined){
        	this.getListSales();
        }
    },
    methods : {
    	newAdd(){
    		let t = this;
			t.showForm = true;
			t.formOpen = {
				open: true,
				action: 'add',
				data: {},
			};
    	},
    	editItem(i){
    		let t = this;
			t.showForm = true;			
			t.formOpen = {
				open: true,
				action: 'edit',
				data: i,
			};
    	},
    	cancel(){
    		let t = this;
			t.showForm = false;
			t.formOpen.action='add';
			t.formOpen.open=false;
			t.formOpen.data={};
    	},
    	getListSales(){
    		let t = this;
            window.axios.post('/getListSales', {user_id: t.user_id})
            .then((r) => {
				t.list = [];
				t.list = r.data.list;
                console.log('getListSales', t.list);
				t.showForm = false;
            })
            .catch((error) => {
                console.log('error');
            });
        },
	},
    watch:{
        "getUserData": function(){
        	this.user_id = this.$store.getters.getUserData.id;
	        if(this.user_id != undefined){
	        	this.getListSales();
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
