<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FrameworkControl;
use App\Models\ControlOwner;


class FrameworkControlMapping extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'framework_control_mappings';
    protected $primaryKey = 'id';

    protected $fillable = [
            'id',
            'framework_control_id',
            'framework' ,
            'reference_name'
            ];


    public function FrameworkControl()
    {
        return $this->belongsToMany(FrameworkControl::class,'framework_control_mappings' , 'id');
    }

    public function owners()
    {
       return $this->FrameworkControl->owners();

    }

    public function classes()
    {
       return $this->FrameworkControl->classes();

    }

    public function phases()
    {
       return $this->FrameworkControl->phases();

    }

    public function priorities()
    {
       return $this->FrameworkControl->priorities();

    }
    public function maturities()
    {
       return $this->FrameworkControl->maturities();

    }
    public function desiredMaturities()
    {
       return $this->FrameworkControl->desiredMaturities();

    }
    public function families()
    {
       return $this->FrameworkControl->families();

    }

}
