@extends('layouts.app')
@section('content')



 <div id="UnidadeController">

 </div>
<div id="manage-vue">
@{{ messagem }}
<div v-for="u in items">
  @{{u.nome}}
</div>

 <div class="form-group row add">
   <div class="col-md-12">
     <h1><small>lista</small> Unidades</h1>
   </div>
   <div class="col-md-12">
     <button type="button" data-toggle="modal" data-target="#create-item" class="btn btn-primary">
       Adicionar nova unidade
     </button>
   </div>
 </div>
 <div class="row">
   <div class="table-responsive">
     <table class="table table-borderless">
       <thead>
         <tr>
           <th>nome</th>
           <th>responsável</th>
           <th>endereço</th>
           <th>fone</th>
           <th>email</th>
           <th>Ações</th>
         </tr>
       </thead>
      <tbody>
        <tr v-for="item in items">
          <td>@{{ item.nome }}</td>
          <td>@{{ item.resp }}</td>
          <td>@{{ item.endereco }}</td>
          <td>@{{ item.fone }}</td>
          <td>@{{ item.email }}</td>

          <td>
            <button class="edit-modal btn btn-warning" @click.prevent="editItem(item)">
              <span class="glyphicon glyphicon-edit"></span> Edit
            </button>
            <button class="edit-modal btn btn-danger" @click.prevent="deleteItem(item)">
              <span class="glyphicon glyphicon-trash"></span> Delete
            </button>
          </td>
        </tr>
      </tbody>

     </table>
   </div>
 </div>
 <nav>
   <ul class="pagination">
     <li v-if="pagination.current_page > 1">
       <a href="#" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
         <span aria-hidden="true">«</span>
       </a>
     </li>
     <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']">
       <a href="#" @click.prevent="changePage(page)">
         @{{ page }}
       </a>
     </li>
     <li v-if="pagination.current_page < pagination.last_page">
       <a href="#" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
         <span aria-hidden="true">»</span>
       </a>
     </li>
   </ul>
 </nav>
 <!-- Create Item Modal -->
 <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
         </button>
         <h4 class="modal-title" id="myModalLabel">Criar nova Unidade</h4>
       </div>
       <div class="modal-body">
         <form method="post" enctype="multipart/form-data" v-on:submit.prevent="createItem">
           <div class="form-group">
             <label for="nome">Nome:</label>
             <input type="text" name="nome" class="form-control" v-model="newItem.nome" />
             <span v-if="formErrors['nome']" class="error text-danger">
               @{{ formErrors['nome'] }}
             </span>
           </div>
           <div class="form-group">
             <label for="endereco">Endereço:</label>
             <textarea name="endereco" class="form-control" v-model="newItem.endereco">
             </textarea>
             <span v-if="formErrors['endereco']" class="error text-danger">
               @{{ formErrors['endereco'] }}
             </span>
           </div>
           <div class="form-group">
             <label for="resp">Responsável:</label>
             <textarea name="resp" class="form-control" v-model="newItem.resp">
             </textarea>
             <span v-if="formErrors['resp']" class="error text-danger">
               @{{ formErrors['resp'] }}
             </span>
           </div>
           <div class="form-group">
             <label for="fone">Fone:</label>
             <textarea name="fone" class="form-control" v-model="newItem.fone">
             </textarea>
             <span v-if="formErrors['fone']" class="error text-danger">
               @{{ formErrors['fone'] }}
             </span>
           </div>
           <div class="form-group">
             <label for="email">Email:</label>
             <textarea name="email" class="form-control" v-model="newItem.email">
             </textarea>
             <span v-if="formErrors['email']" class="error text-danger">
               @{{ formErrors['email'] }}
             </span>
           </div>
           <div class="form-group">
             <label for="obs">Observações:</label>
             <textarea name="obs" class="form-control" v-model="newItem.obs">
             </textarea>
             <span v-if="formErrors['obs']" class="error text-danger">
               @{{ formErrors['obs'] }}
             </span>
           </div>
           <div class="form-group">
             <button type="submit" class="btn btn-success">Adicionar</button>
           </div>
         </form>
       </div>
     </div>
   </div>
 </div>
<!-- Edit Item Modal -->
<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">×</span>
       </button>
       <h4 class="modal-title" id="myModalLabel">Edição da unidade</h4>
     </div>
     <div class="modal-body">
       <form method="post" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">
         <div class="form-group">
           <label for="nome">Nome:</label>
           <input type="text" name="nome" class="form-control" v-model="fillItem.nome" />
           <span v-if="formErrorsUpdate['nome']" class="error text-danger">
             @{{ formErrorsUpdate['nome'] }}
           </span>
         </div>
         <div class="form-group">
           <label for="endereco">Endereço:</label>
           <textarea name="endereco" class="form-control" v-model="fillItem.endereco">
           </textarea>
           <span v-if="formErrorsUpdate['endereco']" class="error text-danger">
             @{{ formErrorsUpdate['endereco'] }}
           </span>
         </div>
         <div class="form-group">
           <label for="resp">Responsável:</label>
           <textarea name="resp" class="form-control" v-model="fillItem.resp">
           </textarea>
           <span v-if="formErrorsUpdate['resp']" class="error text-danger">
             @{{ formErrorsUpdate['resp'] }}
           </span>
         </div>
         <div class="form-group">
           <label for="fone">Fone:</label>
           <textarea name="fone" class="form-control" v-model="fillItem.fone">
           </textarea>
           <span v-if="formErrorsUpdate['fone']" class="error text-danger">
             @{{ formErrorsUpdate['fone'] }}
           </span>
         </div>
         <div class="form-group">
           <label for="email">Email:</label>
           <textarea name="email" class="form-control" v-model="fillItem.email">
           </textarea>
           <span v-if="formErrorsUpdate['email']" class="error text-danger">
             @{{ formErrorsUpdate['email'] }}
           </span>
         </div>
         <div class="form-group">
           <label for="obs">Observações:</label>
           <textarea name="obs" class="form-control" v-model="fillItem.obs">
           </textarea>
           <span v-if="formErrorsUpdate['obs']" class="error text-danger">
             @{{ formErrorsUpdate['obs'] }}
           </span>
         </div>
         <div class="form-group">
           <button type="submit" class="btn btn-success">Editar</button>
         </div>
       </form>
     </div>
   </div>
 </div>
</div>
</div>
@endsection
