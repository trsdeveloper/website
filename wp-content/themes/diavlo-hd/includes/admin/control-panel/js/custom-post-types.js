	jQuery(document).ready(function() {
									var masterForm = jQuery("#posts-filter input[name='post_type']");
									if (masterForm.val() == "i3d-testimonial") {
										var itemsTable = jQuery("#the-list");
										
										if (itemsTable.length > 0) {
											
											jQuery( "#the-list" ).sortable({
												axis: "y",
												placeholder: "ui-state-highlight",
												items: "> tr",
												stop: function(event, ui) { 
													  var baseMenuOrder = jQuery("#edit_i3d-testimonial_per_page").val()  * (jQuery("input[name='paged']").val() - 1);
											
													  jQuery("#the-list tr").each(function(index, element) {
															var id = jQuery(element).attr("id").replace("post-", "");
															jQuery.post(stylesheetDirectory + "/includes/admin/control-panel/update_testimonial_order.php", { 'id': id, "order": index + baseMenuOrder }, function(data) {
															
															});									   
														});
											  
											  
													}
											});			
											
										}
									} else if (masterForm.val() == "i3d-faq") {
										var itemsTable = jQuery("#the-list");
										
										if (itemsTable.length > 0) {
											
											jQuery( "#the-list" ).sortable({
											axis: "y",
											placeholder: "ui-state-highlight",
											items: "> tr",
											stop: function(event, ui) { 
											  var baseMenuOrder = jQuery("#edit_i3d-faq_per_page").val()  * (jQuery("input[name='paged']").val() - 1);
											
											  jQuery("#the-list tr").each(function(index, element) {
											
															var id = jQuery(element).attr("id").replace("post-", "");
											
															jQuery.post(stylesheetDirectory + "/includes/admin/control-panel/update_faq_order.php", { 'id': id, "order": index + baseMenuOrder }, function(data) {
															
															});									   
											});
											  
											  
											}
											
											});			
																						
										}

									} else if (masterForm.val() == "i3d-portfolio-item") {
										
										var itemsTable = jQuery("#the-list");
										
										if (itemsTable.length > 0) {
											
											jQuery( "#the-list" ).sortable({
											axis: "y",
											placeholder: "ui-state-highlight",
											items: "> tr",
											stop: function(event, ui) { 
											  var baseMenuOrder = jQuery("#edit_i3d-portfolio-item_per_page").val()  * (jQuery("input[name='paged']").val() - 1);
											
											  jQuery("#the-list tr").each(function(index, element) {
											
															var id = jQuery(element).attr("id").replace("post-", "");
											//alert(id);
															jQuery.post(stylesheetDirectory + "/includes/admin/control-panel/update_portfolio-item_order.php", { 'id': id, "order": index + baseMenuOrder }, function(data) {
															//alert(data);
															});									   
											});
											  
											  
											}
											
											});			
																						
										}
									} else if (masterForm.val() == "i3d-team-member") {
									//	alert("yuP");
										var itemsTable = jQuery("#the-list");
										
										if (itemsTable.length > 0) {
											
											jQuery( "#the-list" ).sortable({
											axis: "y",
											placeholder: "ui-state-highlight",
											items: "> tr",
											stop: function(event, ui) { 
											  var baseMenuOrder = jQuery("#edit_i3d-team-member_per_page").val()  * (jQuery("input[name='paged']").val() - 1);
											
											  jQuery("#the-list tr").each(function(index, element) {
											
															var id = jQuery(element).attr("id").replace("post-", "");
															//alert(id + " is now " + (index + baseMenuOrder));
															jQuery.post(stylesheetDirectory + "/includes/admin/control-panel/update_team-member_order.php", { 'id': id, "order": index + baseMenuOrder }, function(data) {
															//alert(data);
															});									   
											});
											  
											  
											}
											
											});			
																						
										}
																					
									}									});
	