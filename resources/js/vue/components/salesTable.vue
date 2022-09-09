<template>
	<div class="row">
    	<table class="table table-bordered table-inverse table-hover">
    		<thead>
    			<tr>
    				<th width="50px" class="text-center">Id</th>
    				<th>Customer name</th>
    				<th>Date</th>
    				<th class="text-right">Total</th>
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
    				<td>
    					<div v-if="i.customer!=null">{{i.customer}}</div>
    				</td>
    				<td>{{i.fecha}}</td>
    				<td class="text-right">{{i.total}}</td>
    				<td width="50px" class="text-center">
    					<button type="button" class="btn btn-primary btn-sm" @click="$parent.editItem(i)"><i class="fa fa-edit"></i></button>
    				</td>
    			</tr>
    		</tbody>
    	</table>
    </div>
</template>
<script>
export default {
  name: 'salesTable',
  props: {
	listItems: {
		type: Array,
		default : () => []
	}
  },
  data () {
    return {
    	list: [],
    }
  },
  created(){
  	this.list = this.$parent.list;
  	console.log(this.list)
  },
  watch: {
  	"$parent.list": function(){
  		this.list = this.$parent.list;
  	console.log(this.list)
  	}
  }
}
</script>
<style lang="css" scoped>
</style>