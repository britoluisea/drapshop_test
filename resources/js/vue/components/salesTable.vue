<template>
	<div class="row">
    	<table class="table table-bordered table-inverse table-hover">
    		<thead>
    			<tr>
    				<th width="50px" class="text-center">Id</th>
    				<th>Customer name</th>
    				<th>Date</th>
    				<th class="text-right">Total COP</th>
    				<th class="text-right">Total USD</th>
    				<th class="text-right">Total EUR</th>
    				<th width="50px"></th>
    				<th width="50px"></th>
    			</tr>
    		</thead>
    		<tbody v-if="list.length==0">
    			<tr>
    				<td colspan="8" class="text-center">No record</td>
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
    				<td class="text-right">{{(i.total*toUsd).toFixed(2)}}</td>
    				<td class="text-right">{{(i.total*toEur).toFixed(2)}}</td>
    				<td width="50px" class="text-center">
    					<button type="button" class="btn btn-primary btn-sm" @click="$parent.editItem(i)"><i class="fa fa-edit"></i></button>
    				</td>
    				<td width="50px" class="text-center">
    					<button type="button" class="btn btn-danger btn-sm" @click="$parent.delItem(i)"><i class="fa fa-trash"></i></button>
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
    	toUsd: 1,
    	toEur: 1,
    }
  },
  created(){
  	this.list = this.$parent.list;
  	this.toUsd = this.$parent.toUsd;
  	this.toEur = this.$parent.toEur;
  	console.log(this.list)
  },
  watch: {
  	"$parent.list": function(){
  		this.list = this.$parent.list;
  		this.toUsd = this.$parent.toUsd;
  		this.toEur = this.$parent.toEur;
  	console.log(this.list)
  	}
  }
}
</script>
<style lang="css" scoped>
</style>