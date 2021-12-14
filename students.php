<?php
include("php/dbconnect.php");
include("php/checklogin.php");
$errormsg = '';
$action = "add";


$balance = 0;
$id="";
$sname='';
$matricula='';
$grado='';
$espanol="";
$matematicas='';
$historia='';
$geografia='';
$civica_etica="";
$edu_fisica='';
$ciencias='';

if(isset($_POST['save']))
{

$sname=mysqli_real_escape_string($conn,$_POST['sname']);
$matricula=mysqli_real_escape_string($conn,$_POST['matricula']);
$grado=mysqli_real_escape_string($conn,$_POST['grado']);
$espanol=mysqli_real_escape_string($conn,$_POST['espanol']);
$matematicas=mysqli_real_escape_string($conn,$_POST['matematicas']);
$historia=mysqli_real_escape_string($conn,$_POST['historia']);
$geografia=mysqli_real_escape_string($conn,$_POST['geografia']);
$civica_etica=mysqli_real_escape_string($conn,$_POST['civica_etica']);
$edu_fisica=mysqli_real_escape_string($conn,$_POST['edu_fisica']);
$ciencias=mysqli_real_escape_string($conn,$_POST['ciencias']);



 if($_POST['action']=="add")
 {
//  $remark = mysqli_real_escape_string($conn,$_POST['remark']);
//  $fees = mysqli_real_escape_string($conn,$_POST['fees']);
//  $advancefees = mysqli_real_escape_string($conn,$_POST['advancefees']);
//  $balance = $fees-$advancefees;
 
  $q2 = $conn->query("INSERT INTO student_calif (sname, matricula, grado, espanol, matematicas, historia, geografia, civica_etica, edu_fisica, ciencias) VALUES ('$sname', '$matricula', '$grado', '$espanol', '$matematicas', '$historia', '$geografia', '$civica_etica', '$edu_fisica', '$ciencias')");
  
  $sid2 = $conn->insert_id;
  
 //$conn->query("INSERT INTO  fees_transaction (stdid,paid,submitdate,transcation_remark) VALUES ('$sid','$advancefees','$joindate','$remark')") ;
    
   echo '<script type="text/javascript">window.location="students.php?act=1";</script>';
 
}
// else
//   if($_POST['action']=="update")
//  {
//  $id = mysqli_real_escape_string($conn,$_POST['id']);	
//    $sql = $conn->query("UPDATE  student  SET  matricula  = '$matricula', direccion  = '$direccion', branch  = '$branch', address  = '$address', detail  = '$detail'  WHERE  id  = '$id'");
//    echo '<script type="text/javascript">window.location="student.php?act=2";</script>';
//  }



}




if(isset($_GET['action']) && $_GET['action']=="delete"){

$conn->query("UPDATE  student_calif set delete_status = '1'  WHERE id='".$_GET['id']."'");	
header("location: students.php?act=3");

}


$action = "add";
if(isset($_GET['action']) && $_GET['action']=="edit" ){
$id = isset($_GET['id'])?mysqli_real_escape_string($conn,$_GET['id']):'';

$sqlEdit = $conn->query("SELECT * FROM student_calif WHERE id='".$id."'");
if($sqlEdit->num_rows)
{
$rowsEdit = $sqlEdit->fetch_assoc();
extract($rowsEdit);
$action = "update";
}else
{
$_GET['action']="";
}

}


if(isset($_REQUEST['act']) && @$_REQUEST['act']=="1")
{
$errormsg = "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Excelente!</strong> Estudiante Agregado Exitósamente</div>";
}else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="2")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> <strong>Excelente!</strong> Estudiante Editado Exitósamente</div>";
}
else if(isset($_REQUEST['act']) && @$_REQUEST['act']=="3")
{
$errormsg = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Excelente!</strong> Estudiante Eliminado Exitósamente</div>";
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema de Pago Escolar</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
       <!--CUSTOM BASIC STYLES-->
    <link href="css/basic.css" rel="stylesheet" />
    <!--CUSTOM MAIN STYLES-->
    <link href="css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
	<link href="css/ui.css" rel="stylesheet" />
	<link href="css/datepicker.css" rel="stylesheet" />	
	
    <script src="js/jquery-1.10.2.js"></script>
	
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
   
	
</head>
<?php
include("php/header.php");
?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Estudiantes  
						<?php
						echo (isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")?
						' <a href="students.php" class="btn btn-primary btn-sm pull-right">Volver <i class="glyphicon glyphicon-arrow-right"></i></a>':'<a href="students.php?action=add" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Agregar Calificaciones </a>';
						?>
						</h1>
                     
<?php

echo $errormsg;
?>
                    </div>
                </div>
				
				
				
        <?php 
		 if(isset($_GET['action']) && @$_GET['action']=="add" || @$_GET['action']=="edit")
		 {
		?>
		
			<script type="text/javascript" src="js/validation/jquery.validate.min.js"></script>
                
            
            <div class="row">
				
                    <div class="col-sm-10 col-sm-offset-1">
               <div class="panel panel-primary">
                        <div class="panel-heading">
                           <?php echo ($action=="add")? "Agregar Calificacion": "Editar Calificacion"; ?>
                        </div>
						<form action="students.php" method="post" id="signupForm" class="form-horizontal">
                        <div class="panel-body">
						<fieldset class="scheduler-border" >
						 <legend  class="scheduler-border">Información Personal:</legend>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Nombre* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="sname" name="sname" value="<?php echo $sname;?>"  />
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Matricula* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $matricula;?>"  />
								</div>
						</div>
						<div class="form-group">
						<label class="col-sm-2 control-label" for="Old">Grado Estudiantil*</label>
		  <div class="col-sm-10">
		  <select class="form-control" id="grado" name="grado" required="">
		    	<option>Selecciona</option>
		    	<option value="Primero">Primero</option>
		    	<option value="Segundo">Segundo</option>
		    	<option value="Tercero">Tercero</option>
		    	<option value="Cuarto">Cuarto</option>
		    	<option value="Quinto">Quinto</option>
		    </select>
		  </div>
	  	</div>
				

						
					
                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Calificacion Español* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="espanol" name="espanol" value="<?php echo $espanol;?>" />
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Calificacion Matematicas* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="matematicas" name="matematicas" value="<?php echo $matematicas;?>" />
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Calificacion Historia* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="historia" name="historia" value="<?php echo $historia;?>" />
								</div>
							</div>
                           
                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Calificacion Geografia* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="geografia" name="geografia" value="<?php echo $geografia;?>" />
								</div>
							</div>
                         
                           

                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Calificacion Civica y etica* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="civica_etica" name="civica_etica" value="<?php echo $civica_etica;?>" />
								</div>
							</div>


                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Calificacion Edu. Fisica* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="edu_fisica" name="edu_fisica" value="<?php echo $edu_fisica;?>" />
								</div>
							</div>

                            <div class="form-group">
								<label class="col-sm-2 control-label" for="Old">Calificacion Ciencias* </label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="ciencias" name="ciencias" value="<?php echo $ciencias;?>" />
								</div>
							</div>
                            <div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
								<input type="hidden" name="id" value="<?php echo $id;?>">
								<input type="hidden" name="action" value="<?php echo $action;?>">
								
									<button type="submit" name="save" class="btn btn-primary">Guardar </button>
  
								</div>
							</div>
                         
                         </div>
							</form>
							
                        </div>
                            </div>
            
			
                </div>
               

			   
			   
		<script type="text/javascript">
		

		$( document ).ready( function () {			
			
		$( "#joindate" ).datepicker({
dateFormat:"yy-mm-dd",
changeMonth: true,
changeYear: true,
yearRange: "1970:<?php echo date('Y');?>"
});	
		

		
		if($("#signupForm1").length > 0)
         {
		 
		 <?php if($action=='add')
		 {
		 ?>
		 
			$( "#signupForm1" ).validate( {
				rules: {
					sname: "required",
					
					
				
					
				},
			<?php
			}else
			{
			?>
			
			$( "#signupForm1" ).validate( {
				rules: {
					sname: "required",
					
					
				},
			
			
			
			<?php
			}
			?>
				
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-10" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}

					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-10" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-10" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				}
			} );
			
			}
			
		} );
		
		
		
		$("#fees").keyup( function(){
		$("#advancefees").val("");
		$("#balance").val(0);
		var fee = $.trim($(this).val());
		if( fee!='' && !isNaN(fee))
		{
		$("#advancefees").removeAttr("readonly");
		$("#balance").val(fee);
		$('#advancefees').rules("add", {
            max: parseInt(fee)
        });
		
		}
		else{
		$("#advancefees").attr("readonly","readonly");
		}
		
		});
		
		
		
		
		$("#advancefees").keyup( function(){
		
		var advancefees = parseInt($.trim($(this).val()));
		var totalfee = parseInt($("#fees").val());
		if( advancefees!='' && !isNaN(advancefees) && advancefees<=totalfee)
		{
		var balance = totalfee-advancefees;
		$("#balance").val(balance);
		
		}
		else{
		$("#balance").val(totalfee);
		}
		
		});
		
		
	</script>


			   
		<?php
		}else{
		?>
		
		 <link href="css/datatable/datatable.css" rel="stylesheet" />
		 
		
		 
		 
		<div class="panel panel-default">
                        <div class="panel-heading">
                            Administrar Calificaciones de los Estudiantes  
                        </div>
                        <div class="panel-body">
                            <div class="table-sorting table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tSortable22">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
											<th>Matricula</th>
											<th>Grado</th>
											<th>Español</th>
                                            <th>Matematicas</th>
                                            <th>Historia</th>
											<th>Geografia</th>
											<th>Civica y etica</th>
                                            <th>Edu. Fisica</th>
											<th>Ciencias</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$sql = "select * from student_calif where delete_status='0'";
									$q = $conn->query($sql);
									$i=1;
									while($r = $q->fetch_assoc())
									{
									
									echo '<tr>
                                            <td>'.$i.'</td>
                                            <td>'.$r['sname'].'</td>
											<td>'.$r['grado'].'</td>
											<td>'.$r['espanol'].'</td>
											<td>'.$r['matematicas'].'</td>
                                            <td>'.$r['historia'].'</td>
											<td>'.$r['geografia'].'</td>
                                            <td>'.$r['civica_etica'].'</td>
											<td>'.$r['edu_fisica'].'</td>
                                            <td>'.$r['ciencias'].'</td>
											<td>
											
											

											<a href="students.php?action=edit&id='.$r['id'].'" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
											
											<a onclick="return confirm(\'Deseas realmente eliminar este registro, este proceso es irreversible\');" href="students.php?action=delete&id='.$r['id'].'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a> </td>
											
                                        </tr>';
										$i++;
									}
									?>
									
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     
	<script src="js/dataTable/jquery.dataTables.min.js"></script>
    
     <script>
         $(document).ready(function () {
             $('#tSortable22').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bInfo": false,
    "bAutoWidth": true });
	
         });
		 
	
    </script>
		
		<?php
		}
		?>
				
				
            
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->

    
  
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="js/jquery.metisMenu.js"></script>
       <!-- CUSTOM SCRIPTS -->
    <script src="js/custom1.js"></script>V

    
</body>
</html>
