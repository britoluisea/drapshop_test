<template>
	<div class="row mb-0 ">
    	<table class="table table-bordered table-inverse table-hover" style=" margin-bottom: 20px;">
    		<thead>
    			<tr>
    				<th>Product</th>
    				<th width="100px">Quality</th>
    				<th width="100px">Price</th>
    				<th class="text-right">Total</th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr v-for="(i, index) in $parent.f.listItems" :key="index">
    				<td style="position: relative;">
    					<span class="newProd" @click="newProd(i, index)">New[+]</span>
    					<select v-model="i.id" class="form-control" @change="asignar(i.id, index)">
    						<option :value="0">Uncategory</option>
    						<option  v-for="(p, idx) in i.options" :key="idx" :value="p.id">{{p.name}}</option>
    					</select>
    				</td>
    				<td>
    					<input type="text" class="form-control" v-model="i.q" @keyup="total()">
    				</td>
    				<td>
    					<input type="text" class="form-control" v-model="i.p" @keyup="total()">
    				</td>
    				<td class="text-right">${{(i.q*i.p).toFixed(2)}}</td>
    			</tr>
    		</tbody>
    		<tfoot>
    			<tr>
    				<td colspan="4"> 
    					<button type="button" class="btn btn-light btn-light2" @click="addLinea()">+ Linea</button>
    				</td>
    			</tr>
    		</tfoot>
    	</table>
    	<div class="formProd" v-show="showFormprod">
    		<h3>Add Product</h3>
    		<form @submit.prevent="setProduct()">
				<input type="hidden" name="_token" :value="f.csrf">
				<div class="row mb-3">
	                <label for="nameprod" class="col-md-4 col-form-label text-md-end">Name:</label>
	                <div class="col-md-8">
	                    <input id="nameprod" type="text" class="form-control" v-model="f.name" autocomplete="nameprod">
	                </div>
	            </div>
				<div class="row mb-3">
	                <label for="nameprod" class="col-md-4 col-form-label text-md-end">Sku:</label>
	                <div class="col-md-8">
	                    <input id="nameprod" type="text" class="form-control" v-model="f.sku" autocomplete="nameprod">
	                </div>
	            </div>
				<div class="row mb-3">
	                <label for="nameprod" class="col-md-4 col-form-label text-md-end">Price:</label>
	                <div class="col-md-8">
	                    <input id="nameprod" type="text" class="form-control" v-model="f.price" autocomplete="nameprod">
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
    		
    	</div>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
	name: 'itemsProd',
	props: {
	  edit: {
	    type: Boolean,
	    required: true,
	    default: false
	  }
	},
	data () {
		return {
			showFormprod: false,
			idxFila: 0,
			listprod: [],
			f: {
				name:'',
				sku: 0,
				price: 0,
			},
			user_id: 0,
		}
	},
	created(){
        this.user_id = this.$store.getters.getUserData.id;
        console.log('edit', this.edit)
        if(this.user_id != undefined){
        	this.getListProd();
        }
	},
	methods : {	
		getListProd(){
			let t = this;
			t.user_id = t.$store.getters.getUserData.id;
			window.axios.post('/getListProd', {user_id: t.user_id})
			.then((r) => {
				console.log('getListProd', r);
				t.listprod = [];
				if(r.data.list.length>0){
					t.listprod = r.data.list;
				}
			})
			.catch((error) => {
				console.log('error');
			});
		},
		addLinea(){
			let t = this;
			let prod= {
				options: t.listprod,
				id: 0,
				q: 0,
				p: 0,
				t: 0,
			}
			t.$parent.f.listItems.push(prod);
		},
		setProduct(){
			let t = this;
			t.f.user_id = t.$store.getters.getUserData.id;
			window.axios.post('/createProd', t.f)
			.then((r) => {
				console.log('createProd', r);
				t.cancel();
				t.$parent.f.listItems.map((item, index) => {
					if(t.idxFila==index){
						item.id = r.data.prod.id;
						item.q = r.data.prod.sku;
						item.p = r.data.prod.price;
						item.t = 0;
					}
					if(item.options){
						item.options.push(r.data.prod)
					}
				})
			})
			.catch((error) => {
				console.log('error');
			});

		},
		newProd(i, index){
			let t = this;
			t.showFormprod= true;
			t.idxFila= index;
		},
		cancel(){
			let t = this;
			t.showFormprod= false;
			t.f= {
				name:'',
				sku: 0,
				price: 1,
			};
		},
		asignar(id, idx){
			let t = this;
			t.$parent.f.listItems[idx].options.map((item, index) => {
				if(id==item.id){
					t.$parent.f.listItems[idx].id = item.id;
					t.$parent.f.listItems[idx].q = item.sku;
					t.$parent.f.listItems[idx].p = item.price;
				}
			});
			t.total();
		},
		total() {
    		let t = this;
            return t.$parent.f.listItems.reduce((carry, item) => {
            	let q = (isNaN(item.q)) ? 0 : item.q;
				let p = (isNaN(item.p)) ? 0 : item.p;
                console.log('carry', carry);
				let tt = Number(carry) + (Number(p) * Number(q))
                console.log('total', tt);
                if (isNaN(tt)) {tt=0;}
                t.$parent.f.total = Number(tt)
      			.toFixed(2)
      			.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                return t.$parent.f.total
            }, 0);
        }
	},
    watch:{
        "getUserData": function(){
        	this.user_id = this.$store.getters.getUserData.id;
	        if(this.user_id != undefined){
	        	this.getListProd();
	        }
        },
        "edit": function(){
			let t = this;
        	console.log('edit', t.edit);
        	if(t.edit){
        		let newList = []
        		t.$parent.f.listItems.map((item, index) => {
        			let newItem = item;
        			newItem.options = t.listprod;
        			newItem.id = item.item_id;
        			newList.push(newItem);
        		});
        		t.$parent.f.listItems = [];
        		t.$parent.f.listItems = newList;
        	}
        },
        "$parent.f.listItems": function(){
        	this.total();
        }
    },
    computed: {
        ...mapGetters({ getUserData: 'getUserData' })
    }
}
</script>
<style lang="css" scoped>
span.newProd {
    font-size: 10px;
    position: absolute;
    right: 12px;
    background: #fff;
    padding: 8px 5px;
    top: 10px;
    border-left: 1px solid;
    border-color: #ccc;
    z-index: 1;
}
span.newProd:hover {
	cursor: pointer;
}
.formProd {
    position: fixed;
    border: 1px solid #000;
    width: 350px;
    padding: 10px;
    background: #fff;
    left: 0;
    right: 0px;
    margin: auto;
    z-index: 2;
}
.text-right{
	text-align: right;
}
</style>