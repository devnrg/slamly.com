
	</div>
	<div id="push"></div>
    </div>
    <div id="footer">
      <div class="container">
        <p class="muted credit">&copy; Copyright 2013. All rights reserved.&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>about" target="_blank">About</a> / <a href="<?php echo base_url();?>terms" target="_blank">Terms of use</a></p>
      </div>
    </div>
	</body>
	<script src="<?php echo base_url(); ?>includes/js/bootstrap-dropdown.js"></script>
	<script src="<?php echo base_url(); ?>includes/js/bootstrap-tab.js"></script>
	<script src="<?php echo base_url(); ?>includes/js/bootstrap-modal.js"></script>
	<script src="<?php echo base_url(); ?>includes/js/bootstrap-transition.js"></script>
	<script type="text/javascript">
		$(document).ready(function($){	
			$('a[title]').tooltip();
			$('#dob').datepicker({ dateFormat: "dd-mm-yy", changeMonth: true, changeYear: true, yearRange: "-60:+0", maxDate: 0  });
			$('body').on('hidden', '.modal', function () {
				$(this).removeData('modal');
			});
		});
	</script>
</html>