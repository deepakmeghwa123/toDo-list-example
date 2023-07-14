<?php namespace App\Models;


use CodeIgniter\Model;





class todo_Model extends Model
{
     protected $table='todo';
     protected $primaryKey ='id';
     protected $allowedFields=[
         'task',
         'complete',
         'time',

        
     ];

}


?>