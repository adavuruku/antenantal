<div id="accordion" class="panel-group" style="margin-top:20px;">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title ">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> My Menu </a>
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="glyphicon glyphicon-chevron-down pull-right"></a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="list-group">
					<a style="color:blue;" class="list-group-item" href="useraccountprofile.php?hospitalid=<?php echo $hospitalId;?>" >
						<span class="glyphicon glyphicon-home"></span> View Profile <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:black;" class="list-group-item" href="addContactInfo.php?hospitalid=<?php echo $hospitalId;?>" >
						<span class="glyphicon glyphicon-phone"></span> Add Contact Information <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:black;" class="list-group-item"  href="assignDoctorNurse.php?hospitalid=<?php echo $hospitalId;?>">
						<span class="glyphicon glyphicon-plus"></span> Assign Doctors / Nurses' <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:red;" class="list-group-item" href="createOrViewAppointments.php?hospitalid=<?php echo $hospitalId;?>" >
						<span class="glyphicon glyphicon-plus"></span> Create / View Appointments <span style="color:red"></span><span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					<a style="color:black;" class="list-group-item" href="pregnancyInformation.php?hospitalid=<?php echo $hospitalId;?>">
						<span class="glyphicon glyphicon-book"></span> Pregnancy Information <span class="glyphicon glyphicon-circle-arrow-right pull-right"></span>
					</a>
					
					
					
				</div>
			</div>
		</div>
	</div>
</div>