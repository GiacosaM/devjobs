<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Notifications\NuevoCandidato;

class PostularVacante extends Component
{
    use WithFileUploads;
    public $cv;
    public $vacante;

    protected $rules = [
        'cv'=> 'required|mimes:pdf'
    ];

    public function mount(Vacante $vacante) 
    {
        $this->vacante =$vacante;
    }

    public function postularme ()
    {
        $datos = $this->validate(); // Valida lo definido en Rules
        
        // Almacenar el cv
        $cv = $this->cv->store('public/cv');
        $datos['cv'] = str_replace('public/cv', '', $cv); // Esto es para
        //guardar solamente el normbre del archivo, sin la ruta

        //Crear candidato a la vacante 
        $this->vacante->candidatos()->create([
            'user_id'=>auth()->user()->id,
            'cv'=>$datos['cv']

        ]);

        // Crear notificacion y enviar el email
        $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id,$this->vacante->titulo, auth()->user()->id));



        // Mostrat al usuario un msj OK
        session()->flash('mensaje', 'Se envio correctamente tu informacion, mucha suerte');

        return redirect()->back();


    }

    public function render()
    {
        return view('livewire.postular-vacante');
    }
}
