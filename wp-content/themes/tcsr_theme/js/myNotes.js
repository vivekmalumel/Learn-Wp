class myNotes{
	constructor(){
		this.events();
	}

	events(){
		$('#my-notes').on('click','.delete-note',this.deleteNote);
		$('#my-notes').on('click','.edit-note',this.editNote.bind(this));
		$('#my-notes').on('click','.update-note',this.updateNote.bind(this));
		$('#save-note').on('click',this.createNote.bind(this));
	}
	deleteNote(e){
		var thisNote=$(e.target).parents("li");
		$.ajax({
			beforeSend: function (xhr) {
        		xhr.setRequestHeader( 'X-WP-Nonce', tcsrData.nonce );
    		},
			url:tcsrData.root_url+'/wp-json/wp/v2/notes/'+thisNote.data('id'),
			method:'DELETE',
			success:(response)=>{
				thisNote.slideUp();
				toastr.success("Note Deleted Successfully.");
				console.log("Delete Success");
				console.log(response);
				if(response.noteCount<6){
					$('#note_msg').html('');
				}
			},
			error:(response)=>{
				toastr.info('Sorry! Error Deleting Note.');
				console.log(response);
			}
		});
	}

	editNote(e){
		var thisNote=$(e.target).parents("li");
		if(thisNote.data("state")=="editable"){
			this.makeNoteReadonly(thisNote);
		}
		else{
			this.makeNoteEditable(thisNote);
		}
		
	}
	makeNoteEditable(thisNote){
		thisNote.find(".note-title,.note-body").removeClass("d-none");
		thisNote.find(".note-title-head,.note-body-div").addClass("d-none");
		thisNote.find(".edit-note").html('cancel');
		thisNote.find(".update-note").removeClass("d-none");
		thisNote.data("state","editable");
	}
	makeNoteReadonly(thisNote){
		thisNote.find(".note-title,.note-body").addClass("d-none");
		thisNote.find(".note-title-head,.note-body-div").removeClass("d-none");
		thisNote.find(".edit-note").html('<i class="fas fa-pencil-alt" aria-hidden="true"></i> Edit');
		thisNote.find(".update-note").addClass("d-none");
		thisNote.data("state","cancel");
	}
	updateNote(e){
		var thisNote=$(e.target).parents("li");
		var ourUpdatedPost={
			'title':thisNote.find('.note-title').val(),
			'content':thisNote.find('.note-body').val()
		}
		console.log(ourUpdatedPost.content);
		$.ajax({
			beforeSend: function (xhr) {
        		xhr.setRequestHeader( 'X-WP-Nonce', tcsrData.nonce );
    		},
			url:tcsrData.root_url+'/wp-json/wp/v2/notes/'+thisNote.data('id'),
			method:'POST',
			data:ourUpdatedPost,
			success:(response)=>{
				this.makeNoteReadonly(thisNote);
				thisNote.find('.note-title-head').html(ourUpdatedPost.title);
				thisNote.find('.note-body-div').html(ourUpdatedPost.content);
				toastr.success("Note Updated Successfully.");
				console.log(response);
			},
			error:(response)=>{
				toastr.info('Sorry! Error Updating Note.');
				console.log(response);
			}
		});

	}

	createNote(){
		var ourNewPost={
			'title':$('#new-note-title').val(),
			'content':$('#new-note-body').val(),
			'status' :'publish',
		}
		/*console.log(ourNewPost.content);*/
		$.ajax({
			beforeSend: function (xhr) {
        		xhr.setRequestHeader( 'X-WP-Nonce', tcsrData.nonce );
    		},
			url:tcsrData.root_url+'/wp-json/wp/v2/notes',
			method:'POST',
			data:ourNewPost,
			success:(response)=>{
				toastr.success("Note Created Successfully.");
				$('#new-note-title,#new-note-body').val("");
				$(`
				<li data-id="${response.id}">
				<div class="row">
				<div class="col-8">
				<input type="text" class="note-title form-control form-control-lg lead d-none" value="${response.title.raw}">
				<h2 class="note-title-head ">${response.title.raw}
				</h2>
				</div>
				<div class="note-btn col-4">
				<span class="btn btn-info edit-note "><i class="fas fa-pencil-alt" aria-hidden="true"></i> Edit</span>
				<span class="btn btn-danger delete-note "><i class="fas fa-trash-alt" aria-hidden="true"></i> Delete</span>
				</div>
				</div>
				<textarea class="form-control note-body d-none bg-white" >${response.content.raw}</textarea>
				<div class="note-body-div">
					${response.content.raw}
				</div>
				<span class="btn btn-primary update-note d-none ">Save</span>
				<hr>
			</li>

				`).prependTo('#my-notes').hide().slideDown();
				
			},
			error:(response)=>{
				toastr.info('Sorry! Error Creating Note.');
				console.log(response);
				if(response.responseText=="You have reached your note limit"){
					$('#note_msg').html("<strong>Note limit Reached !</strong>Delete an existing note to make room for a new one");
				}
			}
		});
	}

};
var myNote=new myNotes();