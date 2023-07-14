


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add this code at the top of your view page -->

	
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  <body>

<?php if (session()->has('successMessage')): ?>
  <script>
    toastr.success('<?php echo session()->getFlashdata('successMessage'); ?>');
  </script>
<?php elseif (session()->has('errorMessage')): ?>
  <script>
    toastr.error('<?php echo session()->getFlashdata('errorMessage'); ?>');
  </script>
<?php endif; ?>

	
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>ToDo <b>List</b></h2>
					</div>
					<div class="col-sm-6">
						
						<a href="#addEmployeeModal" class="btn btn-primary" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Task</span></a>
						
						
					</div>
                </div>
            </div>
			
			  <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>id</th>
            <th>TasK</th>
            <th>Status</th>
            <th>edit</th>
            <th>delete<th>
        </tr>
    </thead>
    <tbody id="load-table">
        <?php foreach ($list as $item) { ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['task']; ?></td>
				<td>
            <?php if ($item['complete'] == 0) { ?>
                <button class="btn btn-danger" data-id="<?php echo $item['id']; ?>" data-status="0">Incomplete</button>
            <?php } else if ($item['complete'] == 1) { ?>
                <button class="btn btn-success" data-id="<?php echo $item['id']; ?>" data-status="1">Completed</button>
            <?php } ?>
        </td>


                <td>
				<a href="#editEmployeeModal" class="edit-btn" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>

                </td>
                
				<td>
                    <button class="btn btn-primary delete-btn" data-id="<?php echo $item['id']; ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></button>
                </td>



                
            </tr>
        <?php } ?>
    </tbody>
</table>

        
    </div>
	<!-- add student Modal HTML -->
	<div id="addEmployeeModal" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="addForm" action="<?= base_url('add_task')?>" enctype="multipart/form-data" method="post">
					<div class="modal-header">						
						<h4 class="modal-title">Add Task</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					    <div id="error-message" class="messages"></div>
			            <div id="success-message" class="messages"></div>
					<div class="modal-body">			
						
						<div class="form-group">
							<label>Task Name</label>
							<input type="text" class="form-control" name="sname" required>
						</div>
										
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" id="save-button" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade" >
		<div class="modal-dialog" >
			<div class="modal-content">
				<form id="editForm"action="<?= base_url('edit_task')?>"  method="post">
					<div class="modal-header">						
						<h4 class="modal-title">Edit Task </h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div id="error-message" class="messages"></div>
			            <div id="success-message" class="messages"></div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Task Name</label>
							<input type="text" class="form-control" id="edit-name" name="sname" >
							<input type="text" name="sid" hidden="" id="edit-id">
							
						</div>
					
						
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" value="Save" id="edit-submit">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
</html>


<!-- edit task-->
<script>
$(document).ready(function() {
  // Click event handler for the "Edit" button
  $('.edit-btn').click(function() {
    // Get the parent row of the clicked button
    var row = $(this).closest('tr');

    // Extract the ID and task values from the row
    var id = row.find('td:eq(0)').text();
    var task = row.find('td:eq(1)').text();

    // Set the value in edit form
    $('#edit-id').val(id);
    $('#edit-name').val(task);
	
  });
});
</script>

<!-- delete task risk -->
<script>
	$(document).ready(function() {
  $('.delete-btn').click(function() {
    var id = $(this).data('id');
    
    if (confirm('Are you sure you want to delete this data?')) {
      $.ajax({
        
		url: '<?= base_url('delete-task')?>',
        type: 'POST',
        data: { id: id },
        success: function(response) {
          if (response.success) {
            
            toastr.success('Data deleted successfully!');
              //location.reload();
              window.location.href = '<?= base_url('todo_list')?>';
            
          } else {
            
            toastr.error('Failed to delete data.');
            
            
          }
        },
 
      });
    }
  });
});

	</script>


<!-- update task -->

<script>
	$(document).ready(function() {
  // Click event handler for the "Complete" button
  $('.btn-success, .btn-danger').click(function() {
    var id = $(this).data('id');
    var status = $(this).data('status');

    // Update the status value (1 to 0 or 0 to 1)
    var newStatus = status === 0 ? 1 : 0;
    $(this).data('status', newStatus);

    // Update the button text and class based on the new status
    if (newStatus === 1) {
      $(this).removeClass('btn-danger').addClass('btn-success').text('Completed');
    } else {
      $(this).removeClass('btn-success').addClass('btn-danger').text('Incomplete');
    }

    // Make an AJAX request to update the table value in the database
    $.ajax({
      url: '<?= base_url('update-task')?>',
      type: 'POST',
      data: {
        id: id,
        status: newStatus
      },

    });
  });
});

	</script>