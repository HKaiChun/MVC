<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="https://unpkg.com/vue@next"></script>
</head>

<body >

<div id="main">
<div id="list" v-if="UI=='main'">
	<h1>商品清單</h1>
	<table border=1>
		<tr><td>序號</td><td>商品名稱</td><td>單價</td><td>商品說明</td><td>-</td></tr>
		<tr v-for="pro in dat">
			<td>{{pro.id}}</td>
			<td>{{pro.pName}}</td>
			<td>{{pro.price}}</td>
			<td>{{pro.description}}</td>
			<td><button @click="setQanUI(pro)">加入購物車</button></td>
		</tr>
		<button @click="setUI1('editForm')">查看購物車</button>
	</table>
</div>

<div v-if="UI=='editForm'">
	<h1>我的購物車</h1>
	<button @click="setUI('main')">返回商品清單</button>
	<table border=1>
	<tr><td>序號</td><td>商品名稱</td><td>單價</td><td>商品說明</td>
		<td>數量</td><td>總價</td>
		<td>-</td>
	</tr>
	<tr v-for="pro in dat">
		<td>{{pro.id}}</td>
		<td>{{pro.pName}}</td>
		<td>{{pro.price}}</td>
		<td>{{pro.description}}</td>
		<td>{{pro.number}}</td>
		<td>{{pro.total}}</td>
		<td><button @click="delPro(pro.id)">刪</button></td>
	</tr>
</table>
</div>
<div v-if="UI=='editForm2'">
	商品名稱: {{newPro.pName}} <br/>

	單價: {{newPro.price}} <br>

	商品說明: {{newPro.description}}<br>
	
	數量: <input type="text" v-model="newPro.number"><br>

	<input type='button' @click="addPro(pro)" value="save">
</div>
</div>

<script>
const todoApp= Vue.createApp({
	data() {
		return {
			UI: 'main',
			dat: [],
			newPro: {
				id: -1,
				pName: '',
				price: '',
				description: '',
				number: 0,
				total: 0
			}
		}
	},
	methods: {
		loadList: function () {
			const that=this; //this  ==> stands for vm6. let's save `this` to `that`
			fetch('ManagementControll.php?act=listPro')
			.then(function(response) {
				return response.json();
			})
			.then(function(myJson) {
				//we are inside the callback function, now `this` means the function, not vm6
				//we will use `that` to access vm6
				that.dat = myJson;
				//vm6.dat = myJson;
			});
		},
		loadshoppingList: function () {
			const that=this; //this  ==> stands for vm6. let's save `this` to `that`
			fetch('ManagementControll.php?act=listshopping')
			.then(function(response) {
				return response.json();
			})
			.then(function(myJson) {
				//we are inside the callback function, now `this` means the function, not vm6
				//we will use `that` to access vm6
				that.dat = myJson;
				//vm6.dat = myJson;
			});
		},
		delPro: function (id) {
			const that=this;
			let url="ManagementControll.php?act=delPro&id="+id;
			fetch(url,{
				method: 'POST'
			})
			.then(function(res){return res.text(); }) //取得傳回值，轉為文字
			.then(function(data){
				console.log(data);
				that.setUI1('editForm');
				//that.loadshoppingList();
			})
		},
		addPro: function () {
			const that=this;
			let mydat = new FormData();
			mydat.append( "dat", JSON.stringify(this.newPro) );

			let url="ManagementControll.php?act=addnum";
			fetch(url,{
				method: 'POST',
				body: mydat // 將表單物件放入fetch的body屬性
			})
			.then(function(res){return res.text(); }) //取得傳回值，轉為文字
			.then(function(data){ 
				console.log(data);
				that.setUI('main');
				//that.loadList();
			})
		},
		setQanUI: function(pro) {
			this.newPro=pro;
			this.setUI('editForm2');
		},
		setUI: function(page) {
			this.UI=page;
			this.loadList();
		},
		setUI1: function(page) {
			this.UI=page;
			this.loadshoppingList();
		}
	},
	created() {
		this.loadList();
	}
}).mount("#main");
</script>
</body>
</html>