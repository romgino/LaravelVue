
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//require('./unidade');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));
//Vue.component('unidades', require('./components/Unidade.vue'));

// const app = new Vue({
//     el: '#app',
//     data: {
//       title: "olalalalala"
//
//     }
//
//
// });
Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
const app = new Vue({
  el: '#manage-vue',
  data: {
    messagem: "Vue OK!!!!!!!!",
    items: [],
    pagination: {
      total: 0,
      per_page: 2,
      from: 1,
      to: 0,
      current_page: 1
    },
    offset: 4,
    formErrors:{},
    formErrorsUpdate:{},
    newItem : {'nome':'','endereco':'','resp':'','fone':'','email':'','obs':''},
    fillItem : {'nome':'','endereco':'','resp':'','fone':'','email':'','obs':'', 'id':''}
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + (this.offset * 2);
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
  mounted() {
    this.getVueItems(this.pagination.current_page);
  },
  methods: {
    getVueItems: function(page) {
      this.$http.get('/js/unidades?page='+page).then((response) => {
        //this.$set('items', response.data.data.data);
        Vue.set(this, 'items', response.data.data.data);
        //this.$set('pagination', response.data.pagination);
        Vue.set(this, 'pagination', response.data.pagination);
      });
    },
    createItem: function() {
      var input = this.newItem;
      this.$http.post('/js/unidades',input).then((response) => {
        this.changePage(this.pagination.current_page);
        this.newItem = {'nome':'','endereco':'','resp':'','fone':'','email':'','obs':''};
        $("#create-item").modal('hide');
        toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
      }, (response) => {
        this.formErrors = response.data;
      });
    },
    deleteItem: function(item) {
      this.$http.delete('/js/unidades/'+item.id).then((response) => {
        this.changePage(this.pagination.current_page);
        toastr.success('Post Deleted Successfully.', 'Success Alert', {timeOut: 5000});
      });
    },
    editItem: function(item) {
      this.fillItem.nome = item.nome;
      this.fillItem.id = item.id;
      this.fillItem.endereco = item.endereco;
      this.fillItem.resp = item.resp;
      this.fillItem.fone = item.fone;
      this.fillItem.email = item.email;
      this.fillItem.obs = item.obs;
      $("#edit-item").modal('show');
    },
    updateItem: function(id) {
      var input = this.fillItem;
      this.$http.put('/js/unidades/'+id,input).then((response) => {
        this.changePage(this.pagination.current_page);
        this.newItem = {'nome':'','endereco':'','resp':'','fone':'','email':'','obs':'','id':''};
        $("#edit-item").modal('hide');
        toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
      }, (response) => {
        this.formErrors = response.data;
      });
    },
    changePage: function(page) {
      this.pagination.current_page = page;
      this.getVueItems(page);
    }
  }
});
