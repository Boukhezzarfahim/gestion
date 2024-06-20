<div class="row p-4 pt-5">
    <div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-plus fa-2x"></i> Formulaire de création d'un nouvel utilisateur</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form role="form" wire:submit.prevent="addUser()">
        <div class="card-body">

            <div class="d-flex">
                <div class="form-group flex-grow-1 mr-2">
                    <label >Nom</label>
                    <input type="text" wire:model="newUser.nom" class="form-control @error('newUser.nom') is-invalid @enderror">

                    @error("newUser.nom")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group flex-grow-1">
                    <label >Prénom</label>
                    <input type="text" wire:model="newUser.prenom" class="form-control @error('newUser.prenom') is-invalid @enderror">

                    @error("newUser.prenom")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

          <div class="form-group">
            <label >Sexe</label>
            <select class="form-control @error('newUser.sexe') is-invalid @enderror" wire:model="newUser.sexe">
                <option value="">---------</option>
                <option value="H">Homme</option>
                <option value="F">Femme</option>
            </select>
            @error("newUser.sexe")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
          </div>

          <div class="form-group">
            <label >Adresse e-mail</label>
            <input type="text" class="form-control @error('newUser.email') is-invalid @enderror" wire:model="newUser.email">
            @error("newUser.email")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
          </div>

          <div class="d-flex">
                <div class="form-group flex-grow-1 mr-2">
                    <label >Telephone 1</label>
                    <input type="text" class="form-control @error('newUser.telephone1') is-invalid @enderror" wire:model="newUser.telephone1">
                    @error("newUser.telephone1")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group flex-grow-1">
                    <label >Telephone 2</label>
                    <input type="text" class="form-control" wire:model="newUser.telephone2">
                </div>
            </div>

        <div class="form-group">
            <label >Piece d'identité</label>
            <select class="form-control @error('newUser.pieceIdentite') is-invalid @enderror" wire:model="newUser.pieceIdentite">
                <option value="">---------</option>
                <option value="CNI">CNI</option>
                <option value="PASSPORT">PASSPORT</option>
                <option value="PERMIS DE CONDUIRE">PERMIS DE CONDUIRE</option>
            </select>
            @error("newUser.pieceIdentite")
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
                    <label >Numero de piece d'identité</label>
                    <input type="text" class="form-control @error('newUser.numeroPieceIdentite') is-invalid @enderror" wire:model="newUser.numeroPieceIdentite">
                    @error("newUser.numeroPieceIdentite")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


          <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            {{-- wire:model="newUser.password" --}}
            <input type="text" class="form-control " disabled placeholder="Password" >
          </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-success">Enregistrer</button>
          <button type="button" wire:click="goToListUser()" class="btn btn-warning">Retouner à la liste des utilisateurs</button>
        </div>
      </form>
    </div>
    <!-- /.card -->

  </div>
</div>

<script>
  window.addEventListener('showSuccessMessage' , event=>{
    Swal.fire({
  position: "top-end",
  icon: "success",
  toast: true ,
  title: event.detail.message || "opération effectuée avec succèss",
  showConfirmButton: false,
  timer: 3000
})
  })
</script>