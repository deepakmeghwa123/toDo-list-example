<?php

namespace App\Controllers;
use App\Models\todo_Model;

class todoController extends BaseController
{

   
    public function index()
    {
        $todoobject= new todo_Model(); 
        $data['list']=$todoobject->findAll();
        return view('todoview/todoview',$data);
    }
    public function task_add()
    {
        $todoobject = new todo_Model(); 
    
        $task = $this->request->getPost('sname');
    
        // Check if the task already exists
        $existingTask = $todoobject->where('task', $task)->first();
        if ($existingTask) {
            $errorMessage = "Task already exists!";
            session()->setFlashdata('errorMessage', $errorMessage);
        } else {
            $data = [
                'task' => $task,
                'complete' => '0',
                'time' => time()
            ];
    
            if ($todoobject->save($data)) {
                
                $successMessage = "Successfully added!";
                session()->setFlashdata('successMessage', $successMessage);
            } else {
                
                $errorMessage = "Failed to add task!";
                session()->setFlashdata('errorMessage', $errorMessage);
            }
        }
    
        $data['list'] = $todoobject->findAll();
        return view('todoview/todoview', $data);
    }
    
    public function task_edit()
    {
        $todoobject= new todo_Model(); 
        $id=$this->request->getpost('sid');
        //$complete=$this->request->getpost('complete');
    
        $data = [
           'task' => $this->request->getPost('sname'),
           //'complete'=>$complete,
           'time' => time()
        ];
     
        
        
        $result = $todoobject->update($id, $data);

        if ($result) {
            
            $this->session->setFlashdata('successMessage', 'Task updated successfully.');
        } else {
            
            $this->session->setFlashdata('errorMessage', 'Failed to update data.');
        }
        $data['list']=$todoobject->findAll();
        return view('todoview/todoview',$data);



    }


    public function updateTask()
    {
      
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

       
        $todoobject= new todo_Model(); 
        $result = $todoobject->update($id, ['complete' => $status]);

    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $todoModel = new todo_Model();
        $result = $todoModel->delete($id);

        if ($result) {
            
            $response = [
                'success' => true,
                'message' => 'Data deleted successfully.'
            ];
        } else {
            
            $response = [
                'success' => false,
                'message' => 'Failed to delete data.'
            ];
        }

        return $this->response->setJSON($response);
    
    }

}
