<?php echo form_open(); ?>
Workflow : <?php echo form_dropdown('select_workflow', $select_workflow, $value_workflow,"id='select_workflow'"); ?>
<br/>
Condition : <?php echo form_dropdown('select_condition', $select_condition, $value_condition,"id='select_condition'"); ?>
<br/>
Worker : <?php echo form_dropdown('select_worker', $select_worker, $value_worker,"id='select_worker'"); ?>
<br/>
<input type="button" value="Add" onclick="addStep();">

<ol class="limited_drop_targets vertical">
<?php foreach ($query_process as $row): ?>
	<li data-worker-id="<?php echo $row["wfw_id"] ?>"><?php echo $row["wfw_function"] ?></li>
<?php endforeach ?>
</ol>
<input type="hidden" id="hd_worker_id" name="hd_worker_id">

<input type="submit" value="Save" onclick="return check_before_submit();">
<?php echo form_close(); ?>
<script src="<?php echo js_url() ?>jquery-sortable.js"></script>
<style type="text/css">
	body.dragging, body.dragging * {
	  cursor: move !important;
	}

	.dragged {
	  position: absolute;
	  opacity: 0.5;
	  z-index: 2000;
	}

	ol.example li.placeholder {
	  position: relative;
	  /** More li styles **/
	}
	ol.example li.placeholder:before {
	  position: absolute;
	  /** Define arrowhead **/
	}
</style>
<script type="text/javascript">
	function addStep()
	{
		var worker_id = $("#select_worker :selected").val();
		var worker_name = $("#select_worker :selected").text();
		var text = "";
		text = "<li data-worker-id='"+worker_id+"'>"+worker_name+"</li>";
		$("ol.limited_drop_targets").append(text);
	}
	function check_before_submit()
	{
		var hd_worker_id = $("#hd_worker_id");
		var len = $("ol.limited_drop_targets li").length;
		if( hd_worker_id.val() === "" )
		{
			var text = "";
			$("ol.limited_drop_targets li").each(function(index,element)
			{
				if (index == len - 1) 
				{
					text += $(this).attr("data-worker-id");
				}
				else
				{
					text += $(this).attr("data-worker-id")+",";
				}
				
			});
			hd_worker_id.val(text);
		}
		return true;
	}
	$(document).ready(function()
	{
		var group = $("ol.limited_drop_targets").sortable({
		group: 'limited_drop_targets',
		  isValidTarget: function  (item, container) {
		    if(item.is(".highlight"))
		      return true
		    else {
		      return item.parent("ol")[0] == container.el[0]
		    }
		  },
		  onDrop: function (item, container, _super) {
		    $('#hd_worker_id').val(group.sortable("serialize").get().join("\n"))
		    _super(item, container);
		  },
		  serialize: function (parent, children, isContainer) {
		    //return isContainer ? children.join() : parent.text()
		    return isContainer ? children.join() : parent.attr("data-worker-id");
		  },
		  tolerance: 6,
		  distance: 10
		});

		$("#select_workflow").change(function()
		{
			$.ajax({
				url: '../get_condition_for_select_ajax/'+$(this).val(),
				type: 'POST',
			})
			.done(function(data) {
				$("#select_condition").html(data);
			});
			
		});
	});
</script>