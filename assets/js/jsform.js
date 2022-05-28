/**
* Creator: I. Kennedy Yinusa
* Email: iyinusa@yahoo.co.uk
* Website: https://linkedin.com/in/iyinusa
* Module/App: Js Form
*/

$(function() {
    // Get the form.
    var form = $('#bb_ajax_form');
	var form2 = $('#bb_ajax_form2'); // to allow 2 forms on a page

    // Get the messages div.
    var formMessages = $('#bb_ajax_msg');
	var formMessages2 = $('#bb_ajax_msg2'); // to allow 2 forms on a page

    // Set up an event listener for the contact form.
	$(form).submit(function(event) {
    	// Stop the browser from submitting the form.
    	event.preventDefault();

    	// Serialize the form data.
		var formData = $(form).serializeArray();
		//formData.push({name: 'wordlist', value: 'sjsdjs'});
		//var fData = new FormData($(form)[0]);
		//console.log(fData);
		
		// show prograss loading
		$(formMessages).html('<div class="text-center col-lg-12"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> please wait...</div>');
		
		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			//dataType: 'html',
			data: formData
		}).done(function(msg) {
			// Set the message text.
			$(formMessages).html(msg);
			form.get(0).reset(); // clear all form data
			$('#bb_ajax_reload').load(location.href + ' #bb_ajax_reload'); // reload div
			//$(".modal").modal("hide"); // hide pop-up, if any
		}).fail(function(data) {
			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured, please check your internet connectivity.');
			}
		});
	});
	
	// do this for second form
	$(form2).submit(function(event) {
    	// Stop the browser from submitting the form.
    	event.preventDefault();

    	// Serialize the form data.
		var formData = $(form2).serialize();
		
		// show prograss loading
		$(formMessages2).html('<div class="text-center col-lg-12"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> please wait...</div>');
		
		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form2).attr('action'),
			//dataType: 'html',
			data: formData
		}).done(function(msg) {
			// Set the message text.
			$(formMessages2).html(msg);
			form.get(0).reset(); // clear all form data
		}).fail(function(data) {
			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages2).text(data.responseText);
			} else {
				$(formMessages2).text('Oops! An error occured, please check your internet connectivity.');
			}
		});
	});
	
	//////////===== Dynamic Modal Pop-up ===/////////
	$(".pop").click(function(){
		var pageTitle = $(this).attr('pageTitle');
		var pageName = $(this).attr('pageName');
		$(".modal .modal-title").html(pageTitle);
		$(".modal .modal-body").html('<div class="row"><div class="text-center col-lg-12"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i> Content loading please wait...</div></div>');
		$(".modal").modal("show");
		$(".modal .modal-body").load(pageName);
  	});
	
	$('[data-toggle="tooltip"]').tooltip(); 
});