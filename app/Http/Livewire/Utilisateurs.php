<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Utilisateurs extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; 

    public $isBtnAddClicked = false ;

    public $currentPage = PAGELIST;

    public $newUser = [];
    public $editUser = [];
    
    protected $listeners = ['deleteUser'];

    // protected $rules = [
    //      'newUser.nom' => 'required',
    //      'newUser.prenom' => 'required',
    //      'newUser.email' => 'required|email|unique:users,email',
    //      'newUser.telephone1' => 'required|numeric|unique:users,telephone1',
    //      'newUser.pieceIdentite' => 'required',
    //      'newUser.sexe' => 'required',
    //      'newUser.numeroPieceIdentite' => 'required|unique:users,numeroPieceIdentite',
    //     //  'newUser.password' => 'required|string|min:8' 
    // ];

    public function render()
    {
        return view('livewire.utilisateurs.index',[

            "users" => User::latest()->paginate(7)

        ])
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function rules(){
        if($this->currentPage == PAGEEDITFORM){

            // 'required|email|unique:users,email Rule::unique("users", "email")->ignore($this->editUser['id'])
            return [
                'editUser.nom' => 'required',
                'editUser.prenom' => 'required',
                'editUser.email' => ['required', 'email', Rule::unique("users", "email")->ignore($this->editUser['id']) ] ,
                'editUser.telephone1' => ['required', 'numeric', Rule::unique("users", "telephone1")->ignore($this->editUser['id']) ]  ,
                'editUser.pieceIdentite' => ['required'],
                'editUser.sexe' => 'required',
                'editUser.numeroPieceIdentite' => ['required', Rule::unique("users", "pieceIdentite")->ignore($this->editUser['id']) ],
            ];
        }

        return [
            'newUser.nom' => 'required',
            'newUser.prenom' => 'required',
            'newUser.email' => 'required|email|unique:users,email',
            'newUser.telephone1' => 'required|numeric|unique:users,telephone1',
            'newUser.pieceIdentite' => 'required',
            'newUser.sexe' => 'required',
            'newUser.numeroPieceIdentite' => 'required|unique:users,numeroPieceIdentite',
        ];
    }

    public function goToAddUser(){

       $this->currentPage = PAGECREATEFORM;
    }

    public function goToEditUser($id){
        $this->editUser = User::find($id)->toArray();


        $this->currentPage = PAGEEDITFORM;
    }


    public function goToListUser(){

        $this->currentPage = PAGELIST;
        $this->editUser = [];
    }

    public function addUser(){

        $validationAttributes = $this->validate();
        $validationAttributes['newUser']['password'] = "password";

        // bcrypt($validationAttribute['newUser']['password']);

       User::create(  $validationAttributes["newUser"]);

       $this->newUser = [];

       $this->dispatchBrowserEvent("showSuccessMessage", ['message' => 'Utilisateur créé avec succèes!']);
        
    }

    public function updateUser(){
        $validationAttributes = $this->validate();

       User::find($this->editUser["id"])->update( $validationAttributes["editUser"]);
       
       $this->dispatchBrowserEvent("showSuccessMessage", ['message' => 'Utilisateur mis à jour avec succèes!']);
    }

    public function confirmDelete($name, $id){

        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => "Vous êtes sur le point de supprimer $name de la liste des utilisateurs. 
        Voulez-vous vraiment supprimer?" ,  
         "data" => [
            "user_id" => $id
        ]]);
    
    }

    public function deleteUser($id){

        User::destroy($id);

       $this->dispatchBrowserEvent("showSuccessMessage", ['message' => 'Utilisateur supprimé avec succèes!']);



    }

}
