<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Dashboard</div>
					<div class="card-body">
						Welcome <strong>{{userData.name}}</strong>
						<br>
						You are logged in!
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>	
import { mapGetters } from "vuex";
export default {
	name: 'home',
	data () {
		return {
			userData: {},
		}
	},
    created(){
        this.userData = this.$store.getters.getUserData
    },
    watch:{
        "getUserData": function(){
            this.userData = this.$store.getters.getUserData;
        }
    },
    computed: {
        ...mapGetters({ getUserData: 'getUserData' })
    }
}
</script>
<style lang="css" scoped>
</style>
