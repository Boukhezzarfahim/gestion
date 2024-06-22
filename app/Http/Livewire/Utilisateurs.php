<?php

namespace App\Http\Livewire;


use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Utilisateurs extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $isBtnAddClicked = false ;

    public $currentPage = PAGELIST;

    public $newUser = [];
    public $editUser = [];

    public $rolePermissions = [];

    // protected $messages = [
    //     'newUser.nom.required' => "le nom de l'utilisateur est requis.",
    // ];

    // protected $validationAttributes = [
    //     'newUser.telephone1' => 'numero de telephone 1',
    //     'newUser.prenom' => 'firstname',
    // ];
     //  'newUser.password' => 'required|string|min:8' 

    public function render()
    {

        Carbon::setLocale("fr");

        return view('livewire.utilisateurs.index', [
            "users" => User::latest()->paginate(10)
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

    public function goToEditUser($id) {
        $user = User::find($id);
        if ($user) {
            $this->editUser = $user->toArray();
            $this->currentPage = PAGEEDITFORM;
            $this->populateRolePermissions();
          
        } else {
            $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"User not found!"]);
        }
    }

    public function populateRolePermissions(){
        $this->rolePermissions["roles"] = [];
        $this->rolePermissions["permissions"] = [];

        $mapForCB = function($value){
            return $value["id"];
        };

        $roleIds = array_map($mapForCB, User::find($this->editUser["id"])->roles->toArray()); // [1, 2, 4]
        $permissionIds = array_map($mapForCB, User::find($this->editUser["id"])->permissions->toArray()); // [1, 2, 4]

        foreach(Role::all() as $role){
            if(in_array($role->id, $roleIds)){
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id, "role_nom"=>$role->nom, "active"=>true]);
            }else{
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id, "role_nom"=>$role->nom, "active"=>false]);
            }
        }

        foreach(Permission::all() as $permission){
            if(in_array($permission->id, $permissionIds)){
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id, "permission_nom"=>$permission->nom, "active"=>true]);
            }else{
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id, "permission_nom"=>$permission->nom, "active"=>false]);
            }
        }


        // la logique pour charger les roles et les permissions
    }

    public function updateRoleAndPermissions(){
        DB::table("user_role")->where("user_id", $this->editUser["id"])->delete();
        DB::table("user_permission")->where("user_id", $this->editUser["id"])->delete();

        foreach($this->rolePermissions["roles"] as $role){
            if($role["active"]){
                User::find($this->editUser["id"])->roles()->attach($role["role_id"]);
            }
        }

        foreach($this->rolePermissions["permissions"] as $permission){
            if($permission["active"]){
                User::find($this->editUser["id"])->permissions()->attach($permission["permission_id"]);
            }
        }

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Roles et permissions mis à jour avec succès!"]);
    }

    

    public function goToListUser(){
        $this->currentPage = PAGELIST;
        $this->editUser = [];
    }

    public function addUser(){

        // Vérifier que les informations envoyées par le formulaire sont correctes
        $validationAttributes = $this->validate();

        $validationAttributes["newUser"]["password"] = "password";

        // bcrypt($validationAttribute['newUser']['password']);
        User::create($validationAttributes["newUser"]);

        $this->newUser = [];

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur créé avec succès!"]);
    }

    public function updateUser() {
        if (isset($this->editUser["id"])) {
            $validationAttributes = $this->validate();
    
            User::find($this->editUser["id"])->update($validationAttributes["editUser"]);
    
            $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        } else {
            $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"User ID is missing!"]);
        }
    }

    public function confirmPwdReset(){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message"=> [
            "text" => "Vous êtes sur le point de réinitialiser le mot de passe de cet utilisateur. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning"
        ]]);
    }

    public function resetPassword() {
        if (isset($this->editUser["id"])) {
            User::find($this->editUser["id"])->update(["password" => Hash::make(DEFAULTPASSWORD)]);
            $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Mot de passe utilisateur réinitialisé avec succès!"]);
        } else {
            $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"User ID is missing!"]);
        }
    }

    public function confirmDelete($name, $id){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer $name de la liste des utilisateurs. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "data" => [
                "user_id" => $id
            ]
        ]]);
    }

    public function deleteUser($id){
        User::destroy($id);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur supprimé avec succès!"]);
    }
}