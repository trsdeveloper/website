  var currentlySelectedID = "";
	var imageLibraryCount = 0;
	var imageBrowser;
	var timeoutArray = new Array();


function updatePortfolioImage(id, imageID, imgSrc) {
	jQuery("#" + id + "__image_id").val(imageID);
	clearTimeout(timeoutArray[id]);
	jQuery("#" + id + "__img").attr("src", imgSrc);
	jQuery("#" + id + "__img_lnk").css("border-color", "#cccccc");
	closeImageBrowser(id);
}

		function checkImageLibrary(id, resourceType, resourceID, selectedID) {
			//alert(stylesheetDirectory);
			//alert("x");
			if (jQuery("#" + id + "__image_chooser").css("display") != "block") {
				return;
			}
			
			jQuery.post(stylesheetDirectory + "/includes/admin/control-panel/flash_portfolio_check.php", {   cmd: "get_count" }, function(newCount) {																																																																												 
					//alert(newCount);
					//alert(newCount);
					//alert(imageLibraryCount);
					if(parseInt(imageLibraryCount) != parseInt(newCount)) {
						//alert("y");
						jQuery.post(stylesheetDirectory + "/includes/admin/control-panel/flash_portfolio_check.php", { 'id': id, cmd: "refresh", 'resource_type': resourceType, 'resource_id': resourceID, "selected": selectedID }, function(data) {
							imageBrowser.html(data);
							//alert(data);
							timeoutArray[id] = setTimeout("checkImageLibrary('" + id + "', '" + resourceType + "', '" + resourceID + "', '" + selectedID + "')",10000);
						});
					} else {
						//check again in 10 seconds
						timeoutArray[id] = setTimeout("checkImageLibrary('" + id + "', '" + resourceType + "', '" + resourceID + "', '" + selectedID + "')",10000);
					}
				});							
		}


  function chooseImage(id) {
		var resourceType = jQuery("#" + id + "__linktype option:selected").val();
    
		if (resourceType == "") {
			alert("Please choose a link type.");
			return;
		}
		var selectedID = jQuery("#" + id + "__image_id").val();
		
		imageLibraryCount   = -1;
		currentlySelectedID = id;
		var imgEl = jQuery("#" + id);
		//alert(imgEl);
		var pendingHTML = "<div class='loading'>&nbsp;</div>";
		var imageChooser = jQuery("#" + id + "__image_chooser");
		var configTable = jQuery("#" + id + "__table");

		imageBrowser = jQuery("#" + id + "__image_chooser div.imageBrowser");
		//alert(imageBrowser);
    		imageBrowser.html(pendingHTML);
		
		configTable.animate({'opacity':'hide', 'height': 'hide'}, 500, 'linear', 
												 function() {
														imageChooser.animate({'opacity':'show', 'height': 'show'}, 500, 'linear');
		
														var resourceType = jQuery("#" + currentlySelectedID + "__linktype option:selected").val();
												
														if (resourceType == "external") {
															var resourceID = "";
														} else {
															var resourceID   = jQuery("#" + currentlySelectedID + "__" + resourceType + " option:selected").val();
														}
														
														checkImageLibrary(id, resourceType, resourceID, selectedID);												 
												 });
		jQuery("#sortable").sortable('disable');
  }
  function chooseRotatorImage(id) {

var selectedID = jQuery("#" + id + "__image_id").val();
		
		imageLibraryCount   = -1;
		currentlySelectedID = id;
		var imgEl = jQuery("#" + id);
		//alert(imgEl);
		var pendingHTML = "<div class='loading'>&nbsp;</div>";
		var imageChooser = jQuery("#" + id + "__image_chooser");
		var configTable = jQuery("#" + id + "__table");

		imageBrowser = jQuery("#" + id + "__image_chooser div.imageBrowser");
		//alert(imageBrowser);
    imageBrowser.html(pendingHTML);
		var resourceType = "image";
		
		configTable.animate({'opacity':'hide', 'height': 'hide'}, 500, 'linear', 
												 function() {
														imageChooser.animate({'opacity':'show', 'height': 'show'}, 500, 'linear');
		
														var resourceType = jQuery("#" + currentlySelectedID + "__linktype option:selected").val();
												
														if (resourceType == "external") {
															var resourceID = "";
														} else {
															var resourceID   = jQuery("#" + currentlySelectedID + "__" + resourceType + " option:selected").val();
														}
														
														checkImageLibrary(id, resourceType, resourceID, selectedID);												 
												 });
		jQuery("#sortable").sortable('disable');
  }

	function closeImageBrowser(id) {
		
		var imageChooser = jQuery("#" + id + "__image_chooser");
		var configTable   = jQuery("#" + id + "__table");
		
		imageChooser.animate({'opacity':'hide', 'height': 'hide'}, 500, 'linear', 
												 function() {
			configTable.animate({'opacity':'show', 'height': 'show'}, 500, 'linear');
													 
												 });
		jQuery("#sortable").sortable('enable');

	}
	
	function changeLinkType(selectBox,id) {
		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		//document.getElementById('link_details__'+id+"__page").style.display     = "none";
		jQuery("#link_details__"+id+"__page").css("display", "none");
		jQuery("#link_details__"+id+"__post").css("display", "none");
		jQuery("#link_details__"+id+"__external").css("display", "none");
	//	document.getElementById('link_details__'+id+"__post").style.display     = "none";
	//	document.getElementById('link_details__'+id+"__external").style.display = "none";
    
		
		if (selectedValue != "") {
		//  document.getElementById('link_details__'+id+"__" + selectedValue).style.display     = "block";
		  jQuery("#link_details__"+id+"__" + selectedValue).css("display", "block");
		
			selectBox.options[0].disabled = true;
		}
        //alert(selectedValue);
	}

	function changePageSelected(selectBox,id) {
		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		
		if (selectedValue == "") {
		  document.getElementById('link_details__'+id+"__page__misc").style.display     = "none";
		} else {
		  document.getElementById('link_details__'+id+"__page__misc").style.display     = "block";
			
		}
	}
	function changePostSelected(selectBox,id) {
		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		
		if (selectedValue == "") {
		  document.getElementById('link_details__'+id+"__post__misc").style.display     = "block";
		  document.getElementById(id+"__post__title_grp").style.display     = "none";
		} else {
		  document.getElementById('link_details__'+id+"__post__misc").style.display     = "block";
			document.getElementById(id+"__post__title_grp").style.display     = "block";
		
		}
	}

	
	function goMediaWindow() {
		tb_show('Upload Image', 'media-upload.php?type=image&TB_iframe=true&width=220&height=250');
	}
	
	function remove_portfolio_image(id) {
		//get containing div element (container)
		var container = document.getElementById('sortable');

		//get div element to remove
		var olddiv = document.getElementById('image__'+id);

		//remove the div element from the container
		container.removeChild(olddiv);
	}	

