<template>
	<div>
		<headerMain></headerMain>
		<router-view></router-view>
	</div>
</template>
<script>
	import headerMain from "./components/headerMain";
export default {
	components:{
		headerMain,
	},
	name: 'App',
	data () {
		return {
			userData: {},
		}
	},
	created(){
		this.getUserData();
	},
	methods : {		
        getUserData(){
            let t = this;
            window.axios.get('/getUser')
            .then((r) => {
                console.log('getUser', r);
                t.userData = r.data.user;
                t.$store.commit('setUserData', t.userData);
            })
            .catch((error) => {
                console.log('error al obtener data de user');
            })
        },
	}
}
</script>
<style lang="css" scoped>
</style>
